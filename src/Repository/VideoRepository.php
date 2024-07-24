<?php

namespace Alura\Mvc\Repository;

use Alura\Mvc\Entity\Video;

class VideoRepository
{
    public function __construct(private \PDO $pdo)
    {

    }

    public function add(Video $video): bool
    {
        $sql = 'INSERT INTO videos (url, title, image_path) VALUES (?, ?, ?)';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $video->url);
        $statement->bindValue(2, $video->title);
        $statement->bindValue(3, $video->getFilePath());

        $result = $statement->execute();

        $id = $this->pdo->lastInsertId();
        $video->setId(intval($id));
        return $result;
    }

    public function remove(int $id): bool
    {
        $sql = 'DELETE FROM videos WHERE id = ?';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $id);
        return $statement->execute();
    }


    public function update(Video $video): bool
    {
        $updateImageSQL = '';
        if ($video->getFilePath() !== null) {
            $updateImageSQL = ', image_path = :image_path';
        }

        $sql = 'UPDATE videos SET 
                    url = :url, 
                    title = :title' . $updateImageSQL . ' 
                    WHERE id = :id;';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':url', $video->url);
        $statement->bindValue(':title', $video->title);
        $statement->bindValue(':id', $video->id, \PDO::PARAM_INT);
        if ($video->getFilePath() !== null) {
            $statement->bindValue(':image_path', $video->getFilePath());
        }
        return $statement->execute();
    }


    public function all(): array
    {
        $videoList = $this->pdo
            ->query('SELECT * FROM videos')
            ->fetchAll(\PDO::FETCH_ASSOC);

        return array_map(function ($videoData) {
            return $this->hydrateVideo($videoData);
        }, $videoList);
    }

    public function find($id)
    {
        $sql = 'SELECT * FROM videos WHERE id = ?';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $id);
        $statement->execute();
        return $this->hydrateVideo($statement->fetch(\PDO::FETCH_ASSOC));
    }

    public function hydrateVideo(array $videoData): Video
    {
        $video = new Video(
            $videoData['url'],
            $videoData['title'],
        );
        $video->setId(intval($videoData['id']));

        if (isset($videoData['image_path']) !== null) {
            $video->setFilePath($videoData['image_path']);
        }

        return $video;

    }

    public function removeCover(int $id): bool
    {
        $video = $this->find($id);
        if($video === null || $video->getFilePath() === null){
            return false;
        }
        $sql = 'UPDATE videos SET image_path = null WHERE id = ?';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $id);
        return $statement->execute();
    }


    
}