<?php 
session_start(); 
// Zapocinjemo PHP sesiju 
if (!isset($_SESSION['visit_count'])) 
{
     $_SESSION['visit_count'] = 0; 
}

$_SESSION['visit_count'] += 1;

function test_input($data) 
    { 
        $data = trim($data); $data = stripslashes($data); $data = htmlspecialchars($data); return $data; 
    } 

    function store_data_in_json($name, $favorite_food) 
      {
         $file = 'data.json'; 
         if (file_exists($file)) 
         {
             $current_data = file_get_contents($file);
              $array_data = json_decode($current_data, true);
         } else {
             $array_data = []; 
             }
        $array_data[] = array('name' => $name, 'favorite_food' => $favorite_food); $json_data = json_encode($array_data, JSON_PRETTY_PRINT);
               return file_put_contents($file, $json_data);
     } 
if ($_SERVER["REQUEST_METHOD"] === "POST") 
        { 
            $name = test_input($_POST['name']); 
            $favorite_food = test_input($_POST['favorite_food']);
             setcookie('favorite_food', $favorite_food, time() + (86400 * 30), "/");
              // postavljanje kolačića 
              if (store_data_in_json($name, $favorite_food)) 
              {
                 echo "Podaci su uspješno spremljeni."; 
              } else { 
                echo "Došlo je do greške pri spremanju podataka."; 
                     }
         } 
?>

Broj posjeta: <?php echo $_SESSION['visit_count']; ?>