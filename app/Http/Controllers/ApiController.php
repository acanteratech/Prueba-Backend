<?php

namespace App\Http\Controllers;

use App\Http\Request\ShortUrlsRequest;

class ApiController extends Controller
{
    public function shortUrls(ShortUrlsRequest $request): \Illuminate\Http\JsonResponse
    {
        $auth = $request->header('Authorization', '');
        $token = $request->bearerToken();

        if (str_contains($auth, 'Bearer')) {
            if ($this->checkToken($token)) {
                $originalUrl = $request->url;

                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://tinyurl.com/api-create.php?url='.$originalUrl,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_SSL_VERIFYPEER => false
                ));

                $response = curl_exec($curl);

                curl_close($curl);

                return response()->json([
                    'url' => $response
                ]);
            }

            return response()->json([
                'message' => 'Token Invalid'
            ]);
        }

        return response()->json([
            'message' => 'Authorization Required'
        ]);
    }

    /*
     * Checks if token is an empty string, if not calls the bracket checker
     */
    private function checkToken($token): bool
    {
        if (empty($token)) {
            return true;
        } else {
            return $this->checkBrackets($token);
        }
    }

    /*
     * Checks brackets are in order and properly closed and there is no unallowed chars
     */
    private function checkBrackets($token): bool
    {
        $string = str_split($token);
        $stack = array();
        $valid = true;
        foreach($string as $value) {
            switch ($value) {
                case '(': $stack[] = 0;
                    break;

                case ')':
                    if (array_pop($stack) !== 0) {
                        $valid = false;
                    }

                    break;

                case '[': $stack[] = 1;
                    break;

                case ']':
                    if (array_pop($stack) !== 1) {
                        $valid = false;
                    }

                    break;

                case '{': $stack[] = 2;
                    break;

                case '}':
                    if (array_pop($stack) !== 2) {
                        $valid = false;
                    }

                    break;

                default:
                    $valid = false;
            }
        }

        return $valid && empty($stack);
    }
}
