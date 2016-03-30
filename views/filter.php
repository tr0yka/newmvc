<?foreach ($this->files as $file):?>
    <tr>
        <td><a href="/files/download/?file=<?=$file->getId()?>"><?=$file->getOriginalName();?></a></td>
        <td><? echo floor($file->getFileSize()/1024)?></td>
        <td><?=$file->getFileType();?></td>
        <td><?=$file->getDescription();?></td>
        <td><?=$file->getAdded();?></td>
    </tr>
<?endforeach;?>