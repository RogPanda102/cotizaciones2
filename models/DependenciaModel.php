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
        return $this->pdo
            ->query("
                SELECT *
                FROM dependencias
                ORDER BY nombre_oficial ASC
            ")
            ->fetchAll(PDO::FETCH_OBJ);
    }

    public function getById(int $id)
    {
        $stmt = $this->pdo->prepare("
            SELECT *
            FROM dependencias
            WHERE id = :id
        ");

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function create(array $data): bool
    {
        $stmt = $this->pdo->prepare("
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
        ");

        return $stmt->execute([
            ':nombre_oficial' => $data['nombre_oficial'],
            ':nombre_corto'   => $data['nombre_corto']
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare("
            UPDATE dependencias
            SET
                nombre_oficial = :nombre_oficial,
                nombre_corto   = :nombre_corto
            WHERE id = :id
        ");

        return $stmt->execute([
            ':nombre_oficial' => $data['nombre_oficial'],
            ':nombre_corto'   => $data['nombre_corto'],
            ':id'             => $id
        ]);
    }

    public function tienePedidosRelacionados(int $id): bool
    {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*)
            FROM pedidos
            WHERE dependencia_id = :id
        ");

        $stmt->execute([
            ':id' => $id
        ]);

        return (int) $stmt->fetchColumn() > 0;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("
            DELETE FROM dependencias
            WHERE id = :id
        ");

        return $stmt->execute([
            ':id' => $id
        ]);
    }
}