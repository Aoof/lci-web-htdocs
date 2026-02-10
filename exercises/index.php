<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercises Launcher</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="container mx-auto px-4 py-12">
        <div class="text-center mb-12">
            <h1 class="text-5xl font-bold text-gray-800 mb-4">Exercises Launcher</h1>
            <p class="text-xl text-gray-600">Select an exercise to launch</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto">
            <?php
            $exercisesDir = __DIR__; // Current directory is exercises/
            $items = scandir($exercisesDir);
            foreach ($items as $item) {
                if ($item !== '.' && $item !== '..' && is_dir($exercisesDir . '/' . $item)) {
                    // Check if index.php exists in the directory
                    if (file_exists($exercisesDir . '/' . $item . '/index.php')) {
                        echo "
                        <a href=\"$item/index.php\" class=\"group block\">
                            <div class=\"bg-white rounded-lg shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 p-8 border-2 border-transparent hover:border-indigo-500\">
                                <div class=\"flex items-center justify-center mb-4\">
                                    <div class=\"bg-indigo-100 group-hover:bg-indigo-200 rounded-full p-4 transition-colors duration-300\">
                                        <svg class=\"w-12 h-12 text-indigo-600\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\">
                                            <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4\"></path>
                                        </svg>
                                    </div>
                                </div>
                                <h2 class=\"text-2xl font-semibold text-gray-800 text-center mb-2\">Exercise $item</h2>
                                <p class=\"text-gray-500 text-center text-sm\">Click to launch</p>
                            </div>
                        </a>
                        ";
                    }
                }
            }
            ?>
        </div>
    </div>
</body>
</html>
