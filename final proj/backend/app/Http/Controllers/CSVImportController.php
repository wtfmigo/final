<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class CSVImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt',
        ]);

        $file = $request->file('file');
        
        $handle = fopen($file->getPathname(), "r");

        if ($handle === false) {
            return response()->json([
                'message' => [
                    'icon' => 'error',
                    'title' => 'Import Error',
                    'text' => 'Failed to open file.'
                ]
            ], 400);
        }

        $header = true;
        $count = 0;
        while (($row = fgetcsv($handle, 1000, ",")) !== false) {
            if ($header) {
                $header = false; // skip headers
                continue;
            }

            if (isset($row[0], $row[1], $row[2])) {
                $email = $row[1];

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    return response()->json([
                        'message' => [
                            'icon' => 'error',
                            'title' => 'Import Error',
                            'text' => "Email {$email} is invalid."
                        ]
                    ], 201);
                }

                if(User::where('email', $email)->exists()) {
                    return response()->json([
                        'message' => [
                            'icon' => 'error',
                            'title' => 'Import Error',
                            'text' => "Email {$email} already exists."
                        ]
                    ], 201);
                }

                User::create([
                    'name'     => $row[0],
                    'email'    => $email,
                    'password' => password_hash($row[2], PASSWORD_DEFAULT),
                ]);
                $count++;
            }
        }
        fclose($handle);
        return response()->json([
            'message' => [
                'icon' => 'success',
                'title' => 'Import Success',
                'text' => "CSV imported successfully. {$count} records added."
            ]
        ], 201);
    }
}
