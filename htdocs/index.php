<?php

date_default_timezone_set('Europe/Berlin');
session_start();

$file_db = new PDO('sqlite:messaging.sqlite3');
$file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$file_db->exec("
  CREATE TABLE IF NOT EXISTS calls (
      id INTEGER PRIMARY KEY,
      start_date TEXT,
      end_date TEXT,
      call_reason TEXT,
      call_result TEXT,
      customer_number TEXT,
      order_number TEXT,
      something_else TEXT
  )
");

if (!empty($_POST)) {
    $insert = "
      INSERT INTO calls (start_date, end_date, call_reason, call_result, customer_number, order_number, something_else)
      VALUES (:start, :end, :reason, :result, :customer, :order, :else)
    ";

    $stmt = $file_db->prepare($insert);
    $stmt->bindParam(':start', $_POST['start-date']);
    $stmt->bindParam(':end', $_POST['end-date']);
    $stmt->bindParam(':reason', $_POST['call-reason']);
    $stmt->bindParam(':result', $_POST['call-result']);
    $stmt->bindParam(':customer', $_POST['customer-number']);
    $stmt->bindParam(':order', $_POST['order-number']);
    $stmt->bindParam(':else', $_POST['something-else']);

    $stmt->execute();

    header('Location: index.php');
}

$select = 'SELECT id, start_date, end_date, call_reason, call_result, customer_number, order_number, something_else FROM calls ORDER BY id DESC';
$stmt = $file_db->query($select);
$list = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Bootstrap 101 Template</title>

    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap-datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="jquery-datatables/datatables.min.css"/>

    <script src="jquery/jquery-2.2.4.min.js"></script>
    <script src="moment/moment.js"></script>
    <script src="moment/de.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="jquery-datatables/datatables.min.js"></script>
    <script src="js/main.js"></script>

</head>
<body>
<div class="container-fluid">
    <form method="post">
        <div class="row">
            <div class="col-md-12">
                <div class="panel  panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Anrufdaten</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-1">
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary" id="manage-call">Anruf starten</button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class='input-group date datepicker' id="start-date">
                                        <input type='text' class="form-control" name="start-date" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class='input-group date datepicker' id="end-date">
                                        <input type='text' class="form-control" name="end-date" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-danger pull-right" id="submit-call" disabled>Datensatz speichern</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Anrufergebnis</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="call-reason">Grund des Anrufes</label>
                            <select name="call-reason" class="form-control">
                                <option></option>
                                <option>Versehentlich</option>
                                <option>Gezwungen</option>
                                <option>Gewollt</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="call-result">Ergebnis des Anrufes</label>
                            <select name="call-result" class="form-control">
                                <option></option>
                                <option>Erfolgreich</option>
                                <option>Nicht erfolgreich</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">Auftragsdaten</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="call-reason">Kundennummer</label>
                            <input type="text" name="customer-number" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="call-reason">Auftragsnummer</label>
                            <input type="text" name="order-number" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="call-reason">Eine Auswahl</label>
                            <select name="something-else" class="form-control">
                                <option></option>
                                <option>Abc def</option>
                                <option>Ghi jkl</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

<?php if (!empty($list)): ?>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <?php foreach (array_keys(current($list)) as $headline): ?>
                    <th><?= $headline ?></th>
                <?php endforeach ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($list as $idx => $call): ?>
                <tr>
                    <?php foreach ($call as $data): ?>
                        <td><?= $data ?></td>
                    <?php endforeach ?>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
<?php endif ?>
    </div>
</body>
</html>
