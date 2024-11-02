<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Escribir para sanar</title>
  <style>
    @media screen and (max-width: 500px) {
      .content {
        width: 100% !important;
        display: block !important;
        padding: 10px !important;
      }
    }
  </style>
</head>

<body style="font-family: 'Poppins', sans-serif">
  <table border="0" cellspacing="0" cellpadding="0" width="100%" style="background-color: white;">
    <tr>
      <td align="center">
        <table class="content" border="0" cellpadding="0" cellspacing="16" width="500"
          style="border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
          <tbody>
            <tr>
              <td align="center" style="background-color: #364420;">
                <img style="width: 350px;" src="https://mayteherrera.com/images/taller-email.jpg" alt="Taller escribo para sanar">
              </td>
            </tr>
            <tr>
              <td style="padding-top:60px;mso-line-height-alt: 19.2px;font-size:1px;"></td>
            </tr>
            {!! $order->event->mailContent !!}
            <tr>
              <td style="padding-top:60px;mso-line-height-alt: 19.2px;font-size:1px;"></td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
  </table>
</body>

</html>