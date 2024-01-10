<?php
session_start();

if (!isset($_SESSION['userInputs'])) {
  $_SESSION['userInputs'] = [];
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["alphabet"])) {
  $clickedValue = $_POST["alphabet"];
  ButtonClicked($clickedValue);
}


$woorden = ["fortnite", "telescoop", "kees", "laptop", "stoel", "zesentwintig", "hallo"];


if (!isset($_SESSION['gameVariables'])) {
  $_SESSION['gameVariables'] = [
    'tries' => 6,
    'wrongGuess' => [],
    'rightGuess' => [],
    'rightGuesses' => 0
  ];
}

$gameVariables = $_SESSION['gameVariables'];


$tries = $gameVariables['tries'];
$wrongGuess = $gameVariables['wrongGuess'];
$rightGuess = $gameVariables['rightGuess'];
$rightGuesses = $gameVariables['rightGuesses'];


if (!isset($_SESSION['randomWord'])) {
  $woorden = ["fortnite", "telescoop", "kees", "laptop", "stoel", "zesentwintig", "hallo"];
  $randomIndex = rand(0, count($woorden) - 1);
  $_SESSION['randomWord'] = $woorden[$randomIndex];
}



function generateUnderscores($word, $rightGuess)
{
  $displayedWord = '';
  for ($i = 0; $i < strlen($word); $i++) {
    $letter = $word[$i];
    if (in_array($letter, $rightGuess)) {
      $displayedWord .= $letter; 
    } else {
      $displayedWord .= '<span class="underscore" id="underscore_' . $i . '"></span>';
    }
  }
  return $displayedWord;
}


if (!isset($_SESSION['underscores'])) {
  $_SESSION['underscores'] = generateUnderscores($_SESSION['randomWord'], $rightGuess);
}

if (!isset($_SESSION['called'])) {
  $_SESSION['called'] = 0;
}


?>
<div>
<img id="hangman-img" src="../images/hangman-<?php echo (6 - $tries); ?>.svg" alt="">
</div>
<!-- <p> Tries : <?php echo $tries; ?></p> -->
<?php
$gameVariables = $_SESSION['gameVariables'];
$tries = $gameVariables['tries'];

// updateTries($tries);
echo "<p id='triesCount'>Tries:  $tries </p>";

function ButtonClicked($value)
{
  $gameVariables = $_SESSION['gameVariables'];
  $tries = $gameVariables['tries'];
  $wrongGuess = $gameVariables['wrongGuess'];
  $rightGuess = $gameVariables['rightGuess'];
  $rightGuesses = $gameVariables['rightGuesses'];
  $_SESSION['userInputs'][] = $value;
  if ($tries !== 0 && checkWin() == false) {
    if (strpos($_SESSION['randomWord'], $value) === false) {
      if (!in_array($value, $wrongGuess)) {
        array_push($wrongGuess, $value);
        $_SESSION['gameVariables']['wrongGuess'] = $wrongGuess;
        $tries--;
        $_SESSION['gameVariables']['tries'] = $tries;
        echo "<script>document.getElementById('triesCount').innerText = 'Tries: $tries';</script>";
        echo "<span>Foute letters:</span>";
        foreach($wrongGuess as $fout){
          echo " <span>$fout</span> ";
        }
      }
      if ($tries == 0) {
        echo "<h1>Game over! Het goede woord was " . $_SESSION['randomWord'] . " </h1>";
        echo "<img src='https://media.tenor.com/AI6MN-C8muAAAAAM/ltg.gif'>";  
      }
    } else {
      echo "<h3>Correct!</h3>";
      if (!in_array($value, $rightGuess)) {
        array_push($rightGuess, $value);
        $rightGuesses++;
      }
      echo "<span>Foute letters:</span>";
      foreach($wrongGuess as $fout){
        echo " <span> $fout </span> ";
      }

      for ($i = 0; $i < strlen($_SESSION['randomWord']); $i++) {
        if ($_SESSION['randomWord'][$i] === $value) {
          $correctCharacter = $_SESSION['randomWord'][$i];
          $rightGuess[] = $correctCharacter; // Add the correctly guessed letter to the $rightGuess array
          $_SESSION['gameVariables']['rightGuess'] = $rightGuess;
          $_SESSION['underscores'] = generateUnderscores($_SESSION['randomWord'], $rightGuess);
        }
      }
      if (checkWin()) {
        echo "<h1>Je hebt gewonnen! </h1>";
      }
    }
  } else {
    echo "<h1>restart de game om een nieuw potje te beginnen !! :) !!!!</h1>";
  }
}


// function updateWordDisplay($randomWoord, $rightGuess)
// {
//   echo '<div>';
//   for ($i = 0; $i < strlen($_SESSION['randomWord']); $i++) {
//     if (in_array($_SESSION['randomWord'], $rightGuess)) {
//       echo $_SESSION['randomWord'][$i];
//     } else {
//       echo '<span class="underscore" id="underscore_' . $i . '"></span>';
//     }
//   }
//   echo '</div>';
// }


function checkWin()
{
  $randomWoord = $_SESSION['randomWord'];
  $gameVariables = $_SESSION['gameVariables'];
  $rightGuess = $gameVariables['rightGuess'];
  for($i = 0; $i < strlen($randomWoord); $i++){
    $char = $randomWoord[$i];
    if(!in_array($char, $rightGuess)){
      return false;
    }
  }
  // foreach (str_split($randomWoord) as $char) {
  //   if (!in_array($char, $rightGuess)) {
  //     echo "<p> $char</p>";
  //     return false;
  //   }
  // }
  // echo "<p> $char</p>";
  return true;
}
$_SESSION['gameVariables'] = $gameVariables;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../css/style.css">



  <style>
    .underscore {
      width: 20px;
      height: 3px;
      display: inline-block;
      margin: 0 3px;
      background-color: #000;
      ;
    }

    .space {
      width: 20px;
      height: 3px;
      display: inline-block;
      margin: 0 3px;
      background-color: #000;
      ;
    }

    .letter {
      background-color: transparent;
      border: none;
      padding: 3px;
      margin: 0;
      font-size: 20px;
    }

    .letter:hover {
      background-color: wheat;
      cursor: pointer;
    }

    .correct {
      background-color: transparent;
      border: none;
      text-decoration: underline;
    }

    .incorrect {
      background-color: transparent;
      border: none;
      text-decoration: line-through
    }

    .incorrect:hover {
      cursor: default;
      background-color: transparent;
    }

    .correct:hover {
      cursor: default;
      background-color: transparent;
    }
  </style>
</head>

<body>


  <?php
  echo $_SESSION['underscores'];
  ?>

  <form method="post">
    <div id="alphabetButtons">
      <?php


      for ($i = 1; $i <= 26; $i++) {
        $letter = chr($i + 96);
        echo '<input type="submit" class="letter" name="alphabet" value="' . $letter . '">';
      }
    



      ?>
    </div>
  </form>
  <?php

  // if (isset($_SESSION['userInputs']) && !empty($_SESSION['userInputs'])) {
  //   echo "<h2>User Inputs:</h2>";
  //   foreach ($_SESSION['userInputs'] as $input) {
  //     echo "<span>$input</span>";
  //   }
  // }

  ?>
  <!-- <img id="hangman-img" src="../images/hangman-0.svg" alt=""> -->

  <h1 id="gameOver"></h1>
  <h3 id="goedeWoord"></h3>
  <p id="gameOver2"></p>
  <span id="errorMsg"></span>

  <span id="rightGuess"></span>

  <form id="myForm" name='myForm' action="willekeurig.php" method='post'>
  </form>
  <div>
    <span id="tries"></span>
  </div>
  <div>

  </div>
  <!-- <script src="../js/zelfkiezen.js"> -->
  <!-- </script> -->


  <div>
    <a href="destroy_session_willekeurig.php">Herstart</a>
  </div>
  <div>
    <a href="../php/galgje.php">Kies je eigen woord</a>
  </div>

</body>

</html>