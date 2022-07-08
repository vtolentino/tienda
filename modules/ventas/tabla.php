<?php
    $colums="";
    if(isset($_POST['datos'])){
        rsort($_POST['datos']);
        foreach ($_POST['datos'] as $key => $value) {
            $editar="<a onClick='operaciones({$value['id_venta']},{$value['cantidad']},1)'>
                        <i style='font-size: 30px;cursor: pointer;' class='pe-7s-less'></i>
                    </a>
                    <i>|</i>
                    <a onClick='operaciones({$value['id_venta']},{$value['cantidad']},0)'>
                        <i style='font-size: 30px;cursor: pointer;' class='pe-7s-plus'></i>
                    </a>";
            $colums.= "<tr>
                    <td>".$value['id_venta']."</td>
                    <td>".$value['nombre']."</td>
                    <td>$ ".$value['precio']."</td>
                    <td id='{$value['id_venta']}{$value['nombre']}'>".$value['cantidad']."</td>
                    <td>".$value['precio_total']."</td>
                    <td>
                    ".($value['editar']==1?$editar:"")."
                    </td>
                    <td>
                    <a onClick='eliminar({$value['id_venta']})'>
                        <i style='font-size: 30px;cursor: pointer;' class='pe-7s-trash'></i>
                    </a>
                </td>
            </tr>";
        }
    }
    $html="
    <table class='table table-hover table-striped'>
        <thead>
            <th>id</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Precio Total</th>
            <th>Quitar/Agregar</th>
            <th>Eliminar</th>
        </thead>
        <tbody>
            ".$colums."
        </tbody>
    </table>";
    echo json_encode(["html"=>$html]);
?>