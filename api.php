<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(200);
  exit;
}

class DB {
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'benova';
    private $db;

    public function __construct($host = null, $username = null, $password = null, $database = null){
        if ($host !== null) {
            $this->host = $host;
            $this->username = $username;
            $this->password = $password;
            $this->database = $database;
        }

        try {
            $this->db = new PDO(
                'mysql:host='.$this->host.';dbname='.$this->database.';charset=utf8mb4',
                $this->username,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
                ]
            );
          } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["error" => $e->getMessage()]);
            exit;
        }
        
    }

    public function query(string $sql, array $data = []) {
        $req = $this->db->prepare($sql);
        $req->execute($data);
        return $req->fetchAll();
    }
}

$db = new DB();

/* ⚠️ Bonne pratique : ne pas renvoyer le mot de passe */
$result = $db->query(
    "SELECT id_benevole, nom, prenom, email, role, actif, date_creation 
FROM benevole
WHERE role != 'ADMIN';
");

echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
