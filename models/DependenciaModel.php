<?php

class DependenciaModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll()
    {
        $sql = "
            SELECT *
            FROM dependencias
            ORDER BY nombre_oficial ASC
        ";

        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function getById($id)
    {
        $sql = "
            SELECT *
            FROM dependencias
            WHERE id = :id
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function update($id, array $data)
    {
        $sql = "
            UPDATE dependencias
            SET
                nombre_oficial = :nombre_oficial,
                nombre_corto = :nombre_corto
            WHERE id = :id
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':nombre_oficial' => $data['nombre_oficial'],
            ':nombre_corto'   => $data['nombre_corto'],
            ':id'             => $id
        ]);
    }

    public function create(array $data)
    {
        $sql = "
            INSERT INTO dependencias
            (
                nombre_oficial,
                nombre_corto
            )
            VALUES
            (
                :nombre_oficial,
                :nombre_corto
            )
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':nombre_oficial' => $data['nombre_oficial'],
            ':nombre_corto'   => $data['nombre_corto']
        ]);
    }

    public function tienePedidosRelacionados($id)
    {
        $sql = "
            SELECT COUNT(*) as total
            FROM pedidos
            WHERE dependencia_id = :id
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function delete($id)
    {
        $sql = "
            DELETE FROM dependencias
            WHERE id = :id
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }

}