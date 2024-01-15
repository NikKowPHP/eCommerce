<?php
declare(strict_types=1);

namespace App\Models;

class File extends Model
{
	public function getTableName():string
	{
		return 'files';
	}
	public static function upload(string $inputName, string $destinationPath):?string
	{
		if(isset($_FILES[$inputName])) {
			$uploadedFile = $_FILES[$inputName];

			if($uploadedFile['error'] === UPLOAD_ERR_OK) {
				$tempPath = $uploadedFile['tmp_name'];
				$filename = basename($uploadedFile['name']);
				$destination = rtrim($destinationPath, '/'). '/' . $filename;
				if(move_uploaded_file($tempPath, $destination)) {
					return $destination;
				}
			}
		}
		return null;
	}
	public static function delete(string $filePath): bool
	{
		if(file_exists($filePath)) {
			return unlink($filePath);
		}
		return false;
	}
}