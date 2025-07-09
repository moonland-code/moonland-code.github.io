<?php
// Directory configuration
$usersDir = 'users';

// Check if the directory exists
if (!is_dir($usersDir)) {
    die("Users directory not found.");
}

// Fetch user folders
$userFolders = array_filter(scandir($usersDir), function ($folder) use ($usersDir) {
    return is_dir("$usersDir/$folder") && !in_array($folder, ['.', '..']);
});

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Browser</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #122039, #143c81);
            color: white;
            font-size:1.5rem
        }
        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .user-list {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
        }
        .user-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            width: 250px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .user-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }
        .user-card img {
            max-width: 100%;
            border-radius: 10px;
            margin-bottom: 10px;
        }
        .user-card button {
            background: #2a5298;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.2s ease;
        }
        .user-card button:hover {
            background: #1e3c72;
        }
        @media (max-width: 768px) {
            .user-card {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>User Browser</h1>
        <div class="user-list">
            <?php foreach ($userFolders as $folder): ?>
                <?php
                $balanceFile = "$usersDir/$folder/balance.json";
                $profileFile = "$usersDir/$folder/profile.json";
                $photoFile = "$usersDir/$folder/photo.jpg";

                $balance = file_exists($balanceFile) ? json_decode(file_get_contents($balanceFile), true)['total'] : 'N/A';
                $profile = file_exists($profileFile) ? json_decode(file_get_contents($profileFile), true) : null;
                ?>
                <div class="user-card">
                    <?php if (file_exists($photoFile)): ?>
                        <img src="<?php echo "$usersDir/$folder/photo.jpg"; ?>" alt="User Photo">
                    <?php else: ?>
                        <img src="https://via.placeholder.com/250x150" alt="No Photo Available">
                    <?php endif; ?>
                    <h3><?php echo $profile ? $profile['first_name'] . ' ' . $profile['last_name'] : 'Unknown User'; ?></h3>
                    <p><strong>ID:</strong> <?php echo $profile ? $profile['id'] : 'N/A'; ?></p>
                    <p><strong>Balance:</strong> $<?php echo $balance; ?></p>
                    <button onclick="alert('User ID: <?php echo $folder; ?>');">View Details</button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>

