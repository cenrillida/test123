<?php

//
////        error_reporting(E_ALL);
////        ini_set('display_errors', 1);
//
//require "../vendor/autoload.php";
//
//use Firebase\JWT\JWT;
//use Firebase\JWT\Key;
//
//$privateKey = "<<<EOD
//-----BEGIN RSA PRIVATE KEY-----
//MIICXAIBAAKBgQC8kGa1pSjbSYZVebtTRBLxBz5H4i2p/llLCrEeQhta5kaQu/Rn
//vuER4W8oDH3+3iuIYW4VQAzyqFpwuzjkDI+17t5t0tyazyZ8JXw+KgXTxldMPEL9
//5+qVhgXvwtihXC1c5oGbRlEDvDF6Sa53rcFVsYJ4ehde/zUxo6UvS7UrBQIDAQAB
//AoGAb/MXV46XxCFRxNuB8LyAtmLDgi/xRnTAlMHjSACddwkyKem8//8eZtw9fzxz
//bWZ/1/doQOuHBGYZU8aDzzj59FZ78dyzNFoF91hbvZKkg+6wGyd/LrGVEB+Xre0J
//Nil0GReM2AHDNZUYRv+HYJPIOrB0CRczLQsgFJ8K6aAD6F0CQQDzbpjYdx10qgK1
//cP59UHiHjPZYC0loEsk7s+hUmT3QHerAQJMZWC11Qrn2N+ybwwNblDKv+s5qgMQ5
//5tNoQ9IfAkEAxkyffU6ythpg/H0Ixe1I2rd0GbF05biIzO/i77Det3n4YsJVlDck
//ZkcvY3SK2iRIL4c9yY6hlIhs+K9wXTtGWwJBAO9Dskl48mO7woPR9uD22jDpNSwe
//k90OMepTjzSvlhjbfuPN1IdhqvSJTDychRwn1kIJ7LQZgQ8fVz9OCFZ/6qMCQGOb
//qaGwHmUK6xzpUbbacnYrIM6nLSkXgOAwv7XXCojvY614ILTK3iXiLBOxPu5Eu13k
//eUz9sHyD6vkgZzjtxXECQAkp4Xerf5TGfQXGXhxIX52yH+N2LtujCdkQZjXAsGdm
//B2zNzvrlgRmgBrklMTrMYgm1NPcW+bRLGcwgW2PTvNM=
//-----END RSA PRIVATE KEY-----
//EOD";
//
//$publicKey = <<<EOD
//-----BEGIN PUBLIC KEY-----
//MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC8kGa1pSjbSYZVebtTRBLxBz5H
//4i2p/llLCrEeQhta5kaQu/RnvuER4W8oDH3+3iuIYW4VQAzyqFpwuzjkDI+17t5t
//0tyazyZ8JXw+KgXTxldMPEL95+qVhgXvwtihXC1c5oGbRlEDvDF6Sa53rcFVsYJ4
//ehde/zUxo6UvS7UrBQIDAQAB
//-----END PUBLIC KEY-----
//EOD;
//
//$publicKey = "<<<EOD
//-----BEGIN CERTIFICATE-----
//MIIDHDCCAgSgAwIBAgIIBW4H8sIXE2gwDQYJKoZIhvcNAQEFBQAwMTEvMC0GA1UE
//AxMmc2VjdXJldG9rZW4uc3lzdGVtLmdzZXJ2aWNlYWNjb3VudC5jb20wHhcNMjIw
//MTE5MDkzODM2WhcNMjIwMjA0MjE1MzM2WjAxMS8wLQYDVQQDEyZzZWN1cmV0b2tl
//bi5zeXN0ZW0uZ3NlcnZpY2VhY2NvdW50LmNvbTCCASIwDQYJKoZIhvcNAQEBBQAD
//ggEPADCCAQoCggEBAPfioRWjIOo6m6vzVtzVTO2l251JpauunqrkWApcriXlFN4x
//bqFv26O9HGytqX05Zl3kem3DTOaX6CgCKbt5vuMbnyajOMzxte3381LiSdF09FVK
//3m5NOfHxUtX3jTq8BQrK5CzjHcQsN1kiUIunzG2rk/15o+fVE3SgqJpzy4cQGelx
//SUKqX6vZ8Kk2BnWWoc3DPI+nXlNLnNFZAIy9dGr7q0ngfDixB2JsVkvvn4tE1m6F
//7eIew7z8WnJZCc4c8Ah0oTakf+hUieCoSr78UML8u9Olupj/asnV9Kj/8IlISHzd
//H6bYl5i73Jz10LvxTVlY1Zrmfe/9Y9t2tiq/0e8CAwEAAaM4MDYwDAYDVR0TAQH/
//BAIwADAOBgNVHQ8BAf8EBAMCB4AwFgYDVR0lAQH/BAwwCgYIKwYBBQUHAwIwDQYJ
//KoZIhvcNAQEFBQADggEBAKEGWBiUf3RwIM326urLay/hiFmOZr5mu6HYQ0TusLN8
//RfGHujdjBwLbgwuSdYcNiok51NQ3HR+GtLebrFbTOvX7xNsiseT196aFNmV0YBmk
//eHE9cbsQsT82S/gQ2VTj2Af/wtQvyuO3ayhcyXWldeNneDmjEkZHWTQhD/JAB8Md
//oAZQ2Vc7Bv2tf4MNbT5C5tQYOTooAlFm4kyAFX9OmgeUbn4GQshAbFHQMYQ10JxL
//EWuT/+duEHHlhHMkAMwM1oGkR/rpTmjka+pY+VSmZr61zUwk8qXQLkFBlI2VdMj6
//xTIQ73Xft+CZ+br6AGr8fJlAyyIak2gg7mYwmyaF/1A=
//-----END CERTIFICATE-----
//EOD";
//
//$keys = file_get_contents("https://www.googleapis.com/robot/v1/metadata/x509/securetoken@system.gserviceaccount.com");
//
//$keys = json_decode($keys,true);
//
//$publicKey = $keys['3aa148cd0728e303d326de560a35fb1ba32a5149'];
//
//$keysArray = array();
//foreach ($keys as $kid=>$key) {
//    $keysArray[$kid] = new Key($key, "RS256");
//}
//
//$payload = array(
//    "exp" => time()+86400,
//    "iat" => time(),
//    "aud" => "imemo-dissertation-councils",
//    "iss" => "https://securetoken.google.com/imemo-dissertation-councils",
//    "sub" => "1",
//    "auth_time" => time()
//);
//
//$jwt = JWT::encode($payload, $privateKey, 'RS256');
//
//echo "<pre>";
//
//var_dump($jwt);
////echo "Encode:\n" . print_r($jwt, true) . "\n";
//
//$jwt = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjNhYTE0OGNkMDcyOGUzMDNkMzI2ZGU1NjBhMzVmYjFiYTMyYTUxNDkiLCJ0eXAiOiJKV1QifQ.eyJpc3MiOiJodHRwczovL3NlY3VyZXRva2VuLmdvb2dsZS5jb20vaW1lbW8tZGlzc2VydGF0aW9uLWNvdW5jaWxzIiwiYXVkIjoiaW1lbW8tZGlzc2VydGF0aW9uLWNvdW5jaWxzIiwiYXV0aF90aW1lIjoxNjQzMTEwODY4LCJ1c2VyX2lkIjoiZ2hOVkloQ1VjbGNUZDFZNUFqdUFRS2lvMTNuMiIsInN1YiI6ImdoTlZJaENVY2xjVGQxWTVBanVBUUtpbzEzbjIiLCJpYXQiOjE2NDMxMTA4NjgsImV4cCI6MTY0MzExNDQ2OCwicGhvbmVfbnVtYmVyIjoiKzc5OTk4MDA5NDQwIiwiZmlyZWJhc2UiOnsiaWRlbnRpdGllcyI6eyJwaG9uZSI6WyIrNzk5OTgwMDk0NDAiXX0sInNpZ25faW5fcHJvdmlkZXIiOiJwaG9uZSJ9fQ.4YUkkkrEYUUjGClYZ9WZuXbbybkGTBf3cvzvPgZ7WQ8xzzncEvEIuv3tAy13IHimLAKREH_y8W7oW4DjW2sRPh1cTy2zEONCDlgN-kYYoeSUR2LsC6XrUy4Sth4_c_P4FzEIuPaTqdld0K6e4RvxLcymoDciZtwMBM8cY_2KX037d4VrHP6SdL7DTsed5yEMscZiRA8uGTLfDC1cU25fTD9JECfJWW7XVsE0EsQudyOOeeLWWxFWv9WlvpwMnvLncBg3sFAOQFKkIrwJ5WA9wBMjcCnvzwuPMgolGA7wkpDVfl4LwXhqeT0U9LJqvoQ7PUsBp9qYTx_kboZGI1q28Q";
//
//var_dump($jwt);
//
//try {
//    $decoded = JWT::decode($jwt, $keysArray);
//} catch (Exception $exception) {
//    var_dump($exception);
//}
//
//
//echo openssl_error_string();
//
//
///*
// NOTE: This will now be an object instead of an associative array. To get
// an associative array, you will need to cast it as such:
//*/
//
//$decoded_array = (array) $decoded;
//echo "Decode:\n" . print_r($decoded_array, true) . "\n";
//
//echo "</pre>";