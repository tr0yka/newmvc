<table id="sort">
    <thead>
        <tr>
            <th>Название</th>
            <th>Размер (Кб)</th>
            <th>Тип</th>
            <th>Описание</th>
            <th>Дата добавления</th>
        </tr>
    </thead>
    <tbody>
    <?foreach ($this->files as $file):?>
        <tr>
            <td><a href="/files/download/?file=<?=$file->getId()?>"><?=$file->getOriginalName();?></a></td>
            <td><? echo floor($file->getFileSize()/1024)?></td>
            <td><?=$file->getFileType();?></td>
            <td><?=$file->getDescription();?></td>
            <td><?=$file->getAdded();?></td>
        </tr>
    <?endforeach;?>
    </tbody>
</table>

