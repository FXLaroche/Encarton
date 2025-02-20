<?php

namespace App\Model;

use App\Model\AbstractManager;

class ReleasesManager extends AbstractManager
{
    public const TABLE = "album";

    public function add(array $params): void
    {
        $query = "INSERT INTO releases(id, album_id, support, year,  picture, deezer_url) 
        VALUES(:id, :album_id, :support, :year,  :picture, :deezer_url)";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(":id", $params["id"], \PDO::PARAM_STR);
        $stmt->bindValue(":album_id", $params["album_id"], \PDO::PARAM_STR);
        $stmt->bindValue(":support", $params["support"], \PDO::PARAM_STR);
        $stmt->bindValue(":year", $params["year"], \PDO::PARAM_INT);
        $stmt->bindValue(":picture", $params["picture"], \PDO::PARAM_STR);
        $stmt->bindValue(":deezer_url", $params["deezer_url"], \PDO::PARAM_STR);

        $stmt->execute();
    }

    public function selectByIdWithRelease($id)
    {
        $query = "SELECT * FROM artist ar 
        JOIN album al ON ar.id = al.artist_id 
        JOIN releases re ON al.id = re.album_id 
        WHERE re.id = :id;";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(":id", $id, \PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch();
    }
}
