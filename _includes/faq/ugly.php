<?php
//connects a database
include('start.php');
echo '<!DOCTYPE html>';
echo '<html>';
echo '<head>';
echo '<meta charset="utf-8">';
echo '<title>Add a person</title>';
echo '</head>';
echo '<body>';
if(!empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['nickname'])) {
    try {
        $stmt = $db->prepare('INSERT INTO person
                              SET (first_name, last_name, nickname)
                              VALUES (:fn, :ln, :nn)');
        $stmt->bindValue(':fn', $_POST['first_name']);
        $stmt->bindValue(':fn', $_POST['last_name']);
        $stmt->bindValue(':fn', $_POST['nickname']);
        $stmt->execute();
        echo '<span>Person created</span>';
    } catch (Exception $e) {
        echo '<span>Insertion of person failed.</span>';
    }
} else if(!empty($_POST)) {
    echo '<span>Set all required values.</span>';
}
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <label>First name</label>
    <input type="text" name="first_name"
           value="<?php echo !empty($_POST['first_name']) ? $_POST['first_name'] : ''; ?>">
    <br>
    <label>Last name</label>
    <input type="text" name="last_name"
           value="<?php echo !empty($_POST['last_name']) ? $_POST['last_name'] : ''; ?>">
    <br>
    <label>Nickname</label>
    <input type="text" name="nickname"
           value="<?php echo !empty($_POST['nickname']) ? $_POST['nickname'] : ''; ?>">
    <br>
    <input type="submit" value="Save">
</form>
<?php
echo '</body>';
echo '</html>';