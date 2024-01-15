<?php
declare(strict_types=1);

namespace App\Models;

class File extends Model
{
	public function getTableName(): string
	{
		return 'files';
	}
	public static function upload(string $inputName, string $destination, array $allowedExtensions = []): ?string
	{
		if (!isset($_FILES[$inputName]))
			return null;

		$file = $_FILES[$inputName];
		$fileName = $file['name'];
		$fileTmpName = $file['tmp_name'];
		$fileSize = $file['size'];
		$fileError = $file['error'];
		$fileType = $file['type'];

		if ($fileError !== 0) {
			echo 'file has not uploaded';
			return null;
		}
		if (!empty($allowedExtensions)) {
			$fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
			if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
				return null;
			}
		}
		// Generate a unique filename to prevent overwriting
		$uniqueFileName = uniqid() . '_' . $fileName;

		// Move the uploaded file to the destination directory
		$destinationPath = rtrim($destination, '/') . '/' . $uniqueFileName;
		move_uploaded_file($fileTmpName, $destinationPath);
		return $uniqueFileName;
	}
	public static function delete(string $filePath): bool
	{
		if (file_exists($filePath)) {
			return unlink($filePath);
		}
		return false;
	}
}