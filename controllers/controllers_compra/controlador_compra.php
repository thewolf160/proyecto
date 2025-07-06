<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../../vendor/autoload.php';



use Dompdf\Dompdf;
use PHPMailer\PHPMailer\PHPMailer;
    require_once __DIR__ . '/../../models/models_pucharse/modelo_compra1.php';

    /* RECIBIMOS LA SECCION DEL FORMULARIO */
    $seccion = htmlspecialchars($_POST["seccion"] ?? null);
    $modelo = new ModeloCompra();
    $controlador = new Controlador_Compra();

    switch ($seccion) {

        case "Comprar":
            $resultado = $controlador->comprar();
            echo $resultado["error"];

        break;
    }


    class Controlador_Compra {
        private $operaciones;

        public function __construct()
        {
        }

        public function comprar() {
            require_once __DIR__ . '/../../models/models_pucharse/modelo_compra1.php';

            $usuarioId = $_POST['usuario_id'] ?? null;
            $productos = json_decode($_POST['productos'] ?? '[]', true);

            if (!$usuarioId || empty($productos)) {
                return ["error" => "Faltan datos para procesar la compra", "exito" => false];
            }

            $modelo = new ModeloCompra();
            $cliente = $modelo->ObtenerCliente($usuarioId);
            if (!$cliente) {
                return ["error" => "Cliente no encontrado", "exito" => false];
            }

            $total = 0;
            foreach ($productos as $p) {
                $total += $p['cantidad'] * $p['precio_unitario'];
            }

            $resCompra = $modelo->RegistrarCompra([
                "usuario_id" => $usuarioId,
                "total" => $total
            ], $productos);

            if (!$resCompra["exito"]) {
                return ["error" => $resCompra["error"], "exito" => false];
            }

            $modeloCompra = [
                "total" => $total,
                "detalles" => $resCompra["detalles"]
            ];

            $pdf = $this->crearPdfFactura($cliente, $modeloCompra);
            $this->enviarFactura($cliente, $pdf);

            return ["error" => "Compra completada y factura enviada", "exito" => true];
        }




        protected function crearPdfFactura($cliente, $modeloCompra)
        {
            // Paso 1: Generar el HTML de la factura
            
            $html = '
            <style>
                body { font-family: Arial, sans-serif; }
                h1 { text-align: center; }
                .info { margin-bottom: 20px; }
                table { width: 100%; border-collapse: collapse; margin-top: 10px; }
                th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
                th { background-color: #f2f2f2; }
                .total { text-align: right; font-weight: bold; }
            </style>

            <h1>Factura de Compra</h1>

            <div class="info">
                <p><strong>Cliente:</strong> ' . $cliente['nombre'] . '</p>
                <p><strong>Identificación:</strong> ' . $cliente['identificacion'] . '</p>
                <p><strong>Dirección:</strong> ' . $cliente['direccion'] . '</p>
                <p><strong>Correo:</strong> ' . $cliente['correo'] . '</p>
                <p><strong>Fecha:</strong> ' . date("d/m/Y H:i") . '</p>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>';

            foreach ($modeloCompra['detalles'] as $index => $item) {
                $html .= '
                    <tr>
                        <td>' . ($index + 1) . '</td>
                        <td>' . $item['producto'] . '</td>
                        <td>' . $item['cantidad'] . '</td>
                        <td>' . number_format($item['precio_unitario'], 2) . '</td>
                        <td>' . number_format($item['subtotal'], 2) . '</td>
                    </tr>';
            }

            $html .= '
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="total">Total:</td>
                        <td><strong>' . number_format($modeloCompra['total'], 2) . '</strong></td>
                    </tr>
                </tfoot>
            </table>
            ';

            // Paso 2: Convertir HTML a PDF
            $dompdf = new Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->render();
            

            $ruta = __DIR__ . '/facturas/';
            if (!file_exists($ruta)) {
                mkdir($ruta, 0777, true); // crea la carpeta si no existe
            }

            $filename = $ruta . 'factura_' . time() . '.pdf';
            file_put_contents($filename, $dompdf->output());

            if (!file_exists($filename)) {
                error_log("❌ No se pudo generar el PDF en: $filename");
                return false; // o lanzás una excepción si preferís
            }

            return $filename;   
        }

        protected function enviarFactura($cliente, $pdf)
        {
            // Paso 3: Enviar correo con PHPMailer
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // o tu servidor SMTP
            $mail->SMTPAuth = true;
            $mail->Username = 'jaberuskk2q@gmail.com';
            $mail->Password = 'ukocxlibssvlrtuk'; // cuidado con compartirla
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('jaberuskk2q@gmail.com', 'Tienda de Pinturas');
            $mail->addAddress($cliente['correo'], $cliente['nombre']);
            $mail->Subject = 'Tu factura de compra';
            $mail->Body = 'Hemos procesado su compra exitosamente. 
            Su factura en formato PDF ha sido adjuntada a este mensaje. 
            Agradecemos su preferencia.';
            $mail->addAttachment($pdf);

            if ($mail->send()) {
                echo "Correo enviado con éxito";
            } else {
                echo "Error: " . $mail->ErrorInfo;
            }
        }
    }
?>
