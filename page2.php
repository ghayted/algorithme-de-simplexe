<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Linear Programming Solver</title>
    <style>
        body {
            background-color: #f3f4f6; /* Change background color */
            font-family: Arial, sans-serif; /* Change font */
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff; /* Change container background color */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add box shadow */
        }

        h1 {
            font-size: 2.5rem; /* Change heading font size */
            color: #4a5568; /* Change heading color */
            margin-bottom: 20px;
        }

        h2 {
            font-size: 1.8rem; /* Change subheading font size */
            color: #718096; /* Change subheading color */
            margin-top: 20px;
        }

        h3 {
            font-size: 1.6rem; /* Change label font size */
            color: #4a5568; /* Change label color */
            margin-top: 15px;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #cbd5e0; /* Change input border color */
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #4299e1; /* Change button background color */
            color: #ffffff; /* Change button text color */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #2c5282; /* Change button background color on hover */
        }
    </style>
</head>

<body>
    <form action="solve.php" method="post">
        <div class="flex justify-center items-center w-screen h-screen">
            <div class="container mx-auto my-4 px-4 lg:px-20 mt-20">
                <div class="w-full p-8 my-4 md:px-12 lg:w-9/12 lg:pl-20 lg:pr-40 rounded-2xl shadow-2xl bg-white">
                    <div class="flex justify-center">
                        <h1 class="font-bold uppercase">Linear Programming Solver</h1>
                    </div>
                    <h2 class="font-bold uppercase text-large mt-4">Objective Function</h2>
                    <h3 class="font-bold uppercase">Enter the coefficients of the objective function:</h3>
                    <?php
                    if (isset($_POST['submit'])) {
                        $numVariables = intval($_POST['num-variables']);
                    ?>
                        <input class="w-full bg-gray-100 text-gray-900 mt-2 p-3 rounded-lg focus:outline-none focus:shadow-outline" type="text" name="num-variables" min="1" value="<?php echo $numVariables; ?>" />
                        <label for="objective-coefficient-1">MAX(Z) = </label>
                        <br/>
                        <?php
                        for ($i = 1; $i <= $numVariables; $i++) :
                        ?>
                            <label for="objective-coefficient-<?php echo $i ?>">x<?php echo $i ?>:</label>
                            <input class="w-full bg-gray-100 text-gray-900 mt-2 p-3 rounded-lg focus:outline-none focus:shadow-outline" type="number" id="objective-coefficient-<?php echo $i ?>" name="objective_coefficient_<?php echo $i ?>" required />
                        <?php
                        endfor;
                    }
                    ?>
                    <h2 class="font-bold uppercase text-large mt-4">Constraints</h2>
                    <h3 class="font-bold uppercase">Enter the coefficients of the constraints:</h3>
                    <?php
                    if (isset($_POST['submit'])) {
                        $numConstraints = intval($_POST['num-constraints']);
                    ?>
                        <input class="w-full bg-gray-100 text-gray-900 mt-2 p-3 rounded-lg focus:outline-none focus:shadow-outline" name="num-constraints" value="<?php echo $numConstraints; ?>">
                        <?php
                        for ($i = 1; $i <= $numConstraints; $i++) :
                        ?>
                            <h3>Constraint <?php echo $i ?>:</h3>
                            <?php
                            for ($j = 1; $j <= $numVariables; $j++) : ?>
                                <label for="constraint_coefficient_<?php echo $i ?>_<?php echo $j ?>">x<?php echo $j ?>:</label>
                                <input class="w-full bg-gray-100 text-gray-900 mt-2 p-3 rounded-lg focus:outline-none focus:shadow-outline" type="number" id="constraint_coefficient_<?php echo $i ?>_<?php echo $j ?>" name="constraint_coefficient_<?php echo $i ?>_<?php echo $j ?>" required>
                            <?php
                            endfor; ?>
                            <label for="constraint_value_<?php echo $i ?>"> <=:</label>
                            <input class="w-full bg-gray-100 text-gray-900 mt-2 p-3 rounded-lg focus:outline-none focus:shadow-outline" type="number" id="constraint_value_<?php echo $i ?>" name="constraint_value_<?php echo $i ?>" required><br><br>
                        <?php
                        endfor;
                    }
                    ?>
                    <div class="my-2 w-full lg:w-1/4 mt-4 flex justify-center">
                        <button class="uppercase text-sm font-bold tracking-wide bg-blue-900 text-gray-100 p-3 rounded-lg w-full focus:outline-none focus:shadow-outline" type="submit" name="submit1">Solve</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>

</html>
