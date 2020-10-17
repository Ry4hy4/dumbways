<?
$DB_CONFIG = [
'host' => 'localhost',
'user' => 'root',
'passwd' => '',
'db_name' => 'dumbways'
];
$conn = mysqli_connect($DB_CONFIG['host'], $DB_CONFIG['user'], $DB_CONFIG['passwd'], $DB_CONFIG['db_name']);

function read($query){
  global $conn;
  $result= mysqli_query($conn,$query);
  $datas=[];
  while ($data=mysqli_fetch_array($result)){
    $datas[] = $data;
  }
  return $datas;
}


function addMusic($data){
  global $conn;
  $title=$data["title"];
  $durasi=$data["durasi"];
  $genre=$data["rGenre"];
  $singer=$data["rSinger"];
  $photos=upload();
  $deskripsi=$data["deskripsi"];


  $query="INSERT INTO `music` (`id`, `title`, `durasi`, `id_genre`, `id_singer`, `photo`, `deskripsi`) VALUES (NULL, '$title', '$durasi', '$genre', '$singer', '$photos', '$deskripsi');";
  mysqli_query($conn,$query);
}

function addGenre($data){
  global $conn;
  $name = $data["genre"];

  $query="INSERT INTO `genre` (`id`, `name`) VALUES (NULL,'$name');";
  mysqli_query($conn,$query);
}

function addSinger($data){
  global $conn;
  $name = $data["singer"];

  $query="INSERT INTO `singers` (`id`, `name`) VALUES (NULL,'$name');";
  mysqli_query($conn,$query);
}

function upload(){
  $name= $_FILES['photo']['name'];
  $tmp= $_FILES['photo']['tmp_name'];
  move_uploaded_file($tmp,$name);
  return $name;
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dumbways</title>
</head>
<body>
  <?php 
  if(isset($_POST["submit"])){
    addMusic($_POST);
  }
  if(isset($_POST["submitGenre"])){
    addGenre($_POST);
  }  
  if(isset($_POST["submitSinger"])){
    addSinger($_POST);
  }
  ?>
  <form action="" method="post" enctype="multipart/form-data">
  <h1>Add Genre</h1>
  <label for="genre">genre</label>
  <input type="text" id="genre" name="genre"><br>
  <button type="submit" name="submitGenre">submit</button><br><br>

  <h1>Add Singer</h1>
  <label for="singer">singer</label>
  <input type="text" id="singer" name="singer"><br>
  <button type="submit" name="submitSinger">submit</button><br><br>

  <h1>Add music</h1>
  <label for="title">judul</label>
  <input type="text" id="title" name="title"><br>
  <label for="durasi">durasi</label>
  <input type="text" id="durasi" name="durasi"><br>
  <label>genre</label><br>
    <?php 
    $genres = read("SELECT * FROM `genre`") ;
    foreach($genres as $gen):
      ?>  
    <input type="radio" name="rGenre"
    <?php if (isset($rGenre) && $rGenre==$gen['id']) echo "checked";?>
    value=<?= $gen['id'] ?>>
    <label><?= $gen['name'] ?></label><br>
    <?php endforeach ?>
  <label>singer</label><br>
    <?php 
    $singers = read("SELECT * FROM `singers`") ;
    foreach($singers as $sing):
      ?>  
    <input type="radio" name="rSinger"
    <?php if (isset($rSinger) && $rSinger==$sing['id']) echo "checked";?>
    value=<?= $sing['id'] ?>>
    <label><?= $sing['name'] ?></label><br>
    <?php endforeach ?>

  <label for="photo">photo</label>
  <input type="file" id="photo" name="photo"><br>
  <label for="deskripsi">deskripsi</label><br>
  <textarea name="deskripsi" id="deskripsi" cols="30" rows="10"></textarea><br>
  <button type="submit" name="submit">submit</button>
  <h1>Dumb Music Info</h1>











  <label>genre</label><br>
    <?php 
    $genres = read("SELECT * FROM `genre`") ;
    foreach($genres as $gen):
      ?>  
    <input type="radio" name="vGenre"
    <?php if (isset($vGenre) && $vGenre==$gen['id']) echo "checked";?>
    value=<?= $gen['id'] ?>>
    <label><?= $gen['name'] ?></label><br>
    <?php endforeach ?>
    <button type="submit" name="Gfilter">Filter</button>
  <label>singer</label><br>
    <?php 
    $singers = read("SELECT * FROM `singers`") ;
    foreach($singers as $sing):
      ?>  
    <input type="radio" name="vSinger"
    <?php if (isset($vSinger) && $vSinger==$sing['id']) echo "checked";?>
    value=<?= $sing['id'] ?>>
    <label><?= $sing['name'] ?></label><br>
    <?php endforeach ?>
    <button type="submit" name="Sfilter">Filter</button>
    </form>



  <?php 
  if(isset($_POST["Gfilter"])){
  $gfilter=$_POST["vGenre"];
  $musics = read("SELECT * FROM `music` WHERE `id_genre` = '$gfilter' ");
  }if(isset($_POST["Sfilter"])){
  $sfilter=$_POST["vsinger"];
  $musics = read("SELECT * FROM `music` WHERE `id_genre` = '$sfilter' ");
  }else{
  $musics = read("SELECT * FROM `music`");
  }
  foreach($musics as $music):
  ?>
  <div>
  <img src="<?=$music['photo']?>" alt="<?=$music['photo']?>" width="80px" height="80px">  
  <h3><?=$music['title']?></h3>
  <p><?=$music['deskripsi']?></p>
  </div>
  <?php endforeach ?>

</body>
</html>