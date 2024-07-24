<?php
/** @var \League\Plates\Template\Template $this */
$this->layout('layout');
/** @var \Alura\Mvc\Entity\Video[] $videoList */
?>
    <ul class="videos__container" alt="videos alura">
        <?php foreach($videoList as $video): ?>
            <li class="videos__item">
                <?php if($video->getFilePath() !== null):?>
                    <a href="<?$video->url;?>">
                        <img src="/img/<?=$video->getFilePath()?>" alt="" style="width: 100%;"/>
                    </a>
                <?php else: ?>
                <iframe width="100%" height="72%" src="<?= $video->url ?>"
                    title="YouTube video player" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
                <?php endif; ?>
                <div class="descricao-video">
                    <img src="./img/logo.png" alt="logo canal alura">
                    <h3><?= $video->title ?></h3>
                    <div class="acoes-video">
                        <a href="/editar-video?id=<?= $video->id;?>">Editar</a>
                        <?php if($video->getFilePath() !== null):?>
                            <a href="/remover-capa?id=<?= $video->id;?>">Remover Capa</a>
                         <?php endif; ?>
                        <a href="/remover-video?id=<?= $video->id;?>">Excluir</a>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
     </ul>
    <?php require 'fim-html.php';
    