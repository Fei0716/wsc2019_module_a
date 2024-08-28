<?php
// Path to the current directory
$baseDir = __DIR__;
$currentDir = isset($_GET['dir']) ? $_GET['dir'] : $baseDir;

// Ensure the directory is within the base directory
if (strpos(realpath($currentDir), realpath($baseDir)) !== 0) {
    $currentDir = $baseDir;
}

// Delete file or directory
if (isset($_GET['delete'])) {
    $deletePath = $currentDir . '/' . basename($_GET['delete']);
    if (is_file($deletePath)) {
        unlink($deletePath);
    } elseif (is_dir($deletePath)) {
        rmdir($deletePath);
    }
}

// Save file changes
if (isset($_POST['save']) && isset($_POST['filename'])) {
    $filename = $currentDir . '/' . basename($_POST['filename']);
    file_put_contents($filename, $_POST['content']);
}

// Load file content for editing
$fileContent = '';
if (isset($_GET['edit'])) {
    $editPath = $currentDir . '/' . basename($_GET['edit']);
    if (is_file($editPath)) {
        $fileContent = file_get_contents($editPath);
    }
}

// Get directory contents
$files = scandir($currentDir);
function formatSize($size)
{
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    for ($i = 0; $size >= 1024 && $i < count($units) - 1; $i++) {
        $size /= 1024;
    }
    return round($size, 2) . ' ' . $units[$i];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP File Manager</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
<h2>File Manager</h2>
<p>Current Directory: <?php echo realpath($currentDir); ?></p>

<?php if ($fileContent !== ''): ?>
    <h3>Edit File: <?php echo htmlspecialchars(basename($_GET['edit'])); ?></h3>
    <form method="post">
        <textarea name="content" rows="20" cols="100"><?php echo htmlspecialchars($fileContent); ?></textarea><br>
        <input type="hidden" name="filename" value="<?php echo htmlspecialchars($_GET['edit']); ?>">
        <input type="submit" name="save" value="Save">
    </form>
    <hr>
<?php endif; ?>

<table>
    <tr>
        <th>Name</th>
        <th>Size</th>
        <th>Type</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($files as $file): ?>
        <?php if ($file == '.' || $file == '..') continue; ?>
        <tr>
            <td>
                <?php if (is_dir($currentDir . '/' . $file)): ?>
                    <a href="?dir=<?php echo urlencode($currentDir . '/' . $file); ?>"><?php echo $file; ?></a>
                <?php else: ?>
                    <?php echo $file; ?>
                <?php endif; ?>
            </td>
            <td><?php echo is_file($currentDir . '/' . $file) ? formatSize(filesize($currentDir . '/' . $file)) : '-'; ?></td>
            <td><?php echo is_dir($currentDir . '/' . $file) ? 'Directory' : 'File'; ?></td>
            <td>
                <?php if (is_file($currentDir . '/' . $file)): ?>
                    <a href="?edit=<?php echo urlencode($file); ?>&dir=<?php echo urlencode($currentDir); ?>">Edit</a> |
                <?php endif; ?>
                <a href="?delete=<?php echo urlencode($file); ?>&dir=<?php echo urlencode($currentDir); ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
