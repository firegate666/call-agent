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

/**
 * @param PDO $file_db
 * @return array
 */
function getCalls(PDO $file_db) {
    $select = 'SELECT id, start_date, end_date, call_reason, call_result, customer_number, order_number, something_else FROM calls ORDER BY id DESC';
    $stmt = $file_db->query($select);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * @param PDO $file_db
 * @param array $postData
 */
function saveCall(PDO $file_db, $postData) {
    $insert = "
      INSERT INTO calls (start_date, end_date, call_reason, call_result, customer_number, order_number, something_else)
      VALUES (:start, :end, :reason, :result, :customer, :order, :else)
    ";

    $stmt = $file_db->prepare($insert);
    $stmt->bindParam(':start', $postData['start-date']);
    $stmt->bindParam(':end', $postData['end-date']);
    $stmt->bindParam(':reason', $postData['call-reason']);
    $stmt->bindParam(':result', $postData['call-result']);
    $stmt->bindParam(':customer', $postData['customer-number']);
    $stmt->bindParam(':order', $postData['order-number']);
    $stmt->bindParam(':else', $postData['something-else']);

    $stmt->execute();
}
