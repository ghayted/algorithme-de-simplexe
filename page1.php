HTML
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Linear Programming Solver</title>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@2.4.0/dist/daisyui.min.css" rel="stylesheet">
  <style>
    /* Custom styles for a more modern look */
    body {
      font-family: sans-serif;
      background-color: #f5f5f5; /* Light gray background */
    }
    .container {
      max-width: 600px; /* Limit container width for better responsiveness */
      padding: 30px;
      border-radius: 10px; /* Rounded corners */
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    }
    h1 {
      text-align: center;
      margin-bottom: 20px;
    }
    label {
      font-weight: bold;
      display: block;
      margin-bottom: 5px;
    }
    input {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      width: 100%;
    }
    button {
      background-color: #38a3a5; /* Teal button color */
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    button:hover {
      background-color: #2980b9; /* Darker teal on hover */
    }
  </style>
</head>
<body>
<form action="contrants.php" method="post" class="grid grid-cols-1 md:grid-cols-2 gap-6">
  <div class="container mx-auto">

    <h1>Linear Programming Solver</h1>

    <form action="contraintes.php" method="post">
      <div class="mb-6">
        <label for="num-variables" class="form-label">First Number of Variables *</label>
        <input type="number" class="form-control" id="num-variables" name="num-variables" min="1" placeholder="Enter Number" required>
      </div>
      <div class="mb-6">
        <label for="num-constraints" class="form-label">Number of Constraints *</label>
        <input type="number" class="form-control" id="num-constraints" name="num-constraints" min="1" placeholder="Enter Number" required>
      </div>
      <button type="submit" name="submit" class="btn btn-primary">Send</button>
    </form>

  </div>
</form>
</body>
</html>
