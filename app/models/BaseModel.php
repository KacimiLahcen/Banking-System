<?php

abstract class BaseModel
{
    protected static PDO $db;
    protected string $table;

    public function __construct()
    {
        if (!isset(self::$db)) {
            self::$db = new PDO(
                "mysql:host=localhost;dbname=bank",
                "root",
                ""
            );
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    }
    
//save : insert into table in db
    public function save(array $data): bool
{
    $columns = implode(",", array_keys($data));
    $values  = ":" . implode(",:", array_keys($data));

    $sql = "INSERT INTO {$this->table} ($columns) VALUES ($values)";

    $stmt = self::$db->prepare($sql);

    return $stmt->execute($data);
}



//update 
public function update(int $id, array $data): bool
{
    $fields = [];

    foreach ($data as $key => $value) {
        $fields[] = "$key = :$key";
    }

    $sql = "UPDATE {$this->table} SET " . implode(",", $fields) . " WHERE id = :id";
    $data['id'] = $id;

    $stmt = self::$db->prepare($sql);
    return $stmt->execute($data);
}


//delete
public function delete(int $id): bool
{
    $stmt = self::$db->prepare("DELETE FROM {$this->table} WHERE id = ?");
    return $stmt->execute([$id]);
}

//find by id
public function find(int $id): array|false
{
    $stmt = self::$db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// show all
public function all(): array
{
    $stmt = self::$db->query("SELECT * FROM {$this->table}");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}





}

