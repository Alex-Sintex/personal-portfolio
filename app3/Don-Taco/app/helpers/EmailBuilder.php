<?php

namespace App\Helpers;

class EmailBuilder
{
    public static function buildVerificationEmail(string $userName, string $verificationLink, string $logoUrl): string
    {
        return "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8' />
            <meta name='viewport' content='width=device-width, initial-scale=1.0' />
            <title>Verificación de correo</title>
        </head>
        <body style='font-family: Arial, sans-serif; background-color: #f9f9f9; margin:0; padding:0;'>
            <table width='100%' cellpadding='0' cellspacing='0' border='0' style='background-color: #f9f9f9; padding: 20px 0;'>
                <tr>
                    <td align='center'>
                        <table width='600' cellpadding='0' cellspacing='0' border='0' style='background-color: #ffffff; border-radius: 8px; padding: 30px;'>
                            <tr>
                                <td align='center' style='padding-bottom: 20px;'>
                                    <img src='{$logoUrl}' alt='Logo' style='max-width: 150px; height: auto;' />
                                </td>
                            </tr>
                            <tr>
                                <td style='font-size: 18px; color: #333333; padding-bottom: 20px;'>
                                    Hola {$userName},
                                </td>
                            </tr>
                            <tr>
                                <td style='font-size: 16px; color: #555555; padding-bottom: 30px;'>
                                    Por favor, da click en el siguiente enlace para verificar tu email:
                                </td>
                            </tr>
                            <tr>
                                <td align='center' style='padding-bottom: 30px;'>
                                    <a href='{$verificationLink}' style='background-color: #007bff; color: white; padding: 12px 25px; border-radius: 5px; text-decoration: none; font-weight: bold; display: inline-block;'>Verificar correo</a>
                                </td>
                            </tr>
                            <tr>
                                <td style='font-size: 14px; color: #999999;'>
                                    Si no solicitaste este proceso, puedes ignorar este correo.
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </body>
        </html>
        ";
    }

    public static function buildResetCodeEmail(string $userName, string $code, string $logoUrl): string
    {
        return "
    <!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8' />
        <title>Código para restablecer contraseña</title>
    </head>
    <body style='font-family: Arial, sans-serif; background-color: #f7f7f7; padding: 20px;'>
        <div style='max-width: 600px; margin: 0 auto; background-color: #fff; border-radius: 5px; padding: 30px;'>
            <div style='text-align: center;'>
                <img src='{$logoUrl}' alt='Logo' style='max-width: 150px; margin-bottom: 20px;' />
                <h2>Hola {$userName},</h2>
                <p>Este es tu código para restablecer la contraseña:</p>
                <h1 style='color: #007bff;'>{$code}</h1>
                <p>Este código expira en 1 hora.</p>
                <hr />
                <p style='color: #888;'>Si no solicitaste este código, puedes ignorar este mensaje.</p>
            </div>
        </div>
    </body>
    </html>
    ";
    }
}
