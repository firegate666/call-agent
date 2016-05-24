<?php

require_once __DIR__ . '/bootstrap.php';

/** @var PDO $file_db */

if (!empty($_POST)) {
    saveCall($file_db, $_POST);
    header('Location: index.php');
}

$list = getCalls($file_db);
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Bootstrap 101 Template</title>

    <link href="components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
    <link href="components/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet" />

    <script src="components/jquery/dist/jquery.min.js"></script>
    <script src="components/moment/min/moment-with-locales.min.js"></script>
    <script src="components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <script src="components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

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
