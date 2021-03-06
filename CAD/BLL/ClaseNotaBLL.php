<?php

class NotaBLL {

    function insert($titulo, $nota, $idCategoria) {
        $claseConexion = new Connection();
        $resultado = $claseConexion->queryWithParams("CALL sp_tblNota_Insert(:tituloParam,:notaParam,:idCategoriaParam);", array(
            ":tituloParam" => $titulo,
            ":notaParam" => $nota,
            ":idCategoriaParam" => $idCategoria
        ));
        $rowId = $resultado->fetch(PDO::FETCH_ASSOC);
        return $rowId["lastId"];
    }

    function update($id, $fecha, $titulo, $nota) {
        $claseConexion = new Connection();
        $claseConexion->queryWithParams("CALL sp_tblNota_Update(:idParam,:fechaParam,:tituloParam,:notaParam);", array(
            ":idParam" => $id,
            ":fechaParam" => $fecha,
            ":tituloParam" => $titulo,
            ":notaParam" => $nota,
        ));
    }

    function updateCategoria($id, $idCategoria) {
        $claseConexion = new Connection();
        $claseConexion->queryWithParams("CALL sp_tblNota_UpdateCategoria(:idParam,:idCategoriaParam);", array(
            ":idParam" => $id,
            ":idCategoriaParam" => $idCategoria
        ));
    }

    function delete($id) {
        $claseConexion = new Connection();
        $claseConexion->queryWithParams("CALL sp_tblNota_Delete(:idParam)", array(
            ":idParam" => $id
        ));
    }

    function archivar($id, $estado) {
        $claseConexion = new Connection();
        $claseConexion->queryWithParams("CALL sp_tblNota_Archivar(:idParam,:estadoParam)", array(
            ":idParam" => $id,
            ":estadoParam" => $estado
        ));
    }

    function selectAll() {
        $claseConexion = new Connection();
        $resultado = $claseConexion->query("CALL sp_tblNota_SelectAll();");
        $listaNotas = array();
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $objResultado = $this->rowToDto($row);
            $listaNotas[] = $objResultado;
        }
        return $listaNotas;
    }

    function selectById($id) {
        $claseConexion = new Connection();
        $resultado = $claseConexion->queryWithParams("CALL sp_tblNota_SelectById(:idParam);", array(
            ":idParam" => $id
        ));
        if ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $objResultado = $this->rowToDto($row);
            return $objResultado;
        }
        return null;
    }

    function selectByCategoria($idCategoria) {
        $claseConexion = new Connection();
        $resultado = $claseConexion->queryWithParams("CALL sp_tblNota_SelectByCategoria(:idCategoriaParam);", array(
            ":idCategoriaParam" => $idCategoria
        ));
        $listaNotas = array();
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $objResultado = $this->rowToDto($row);
            $listaNotas[] = $objResultado;
        }
        return $listaNotas;
    }

    function selectByEstado($estado) {
        $claseConexion = new Connection();
        $resultado = $claseConexion->queryWithParams("CALL sp_tblNota_SelectByEstado(:estadoParam);", array(
            ":estadoParam" => $estado
        ));
        $listaNotas = array();
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $objResultado = $this->rowToDto($row);
            $listaNotas[] = $objResultado;
        }
        return $listaNotas;
    }

    function searchNota($searchText) {
        $claseConexion = new Connection();
        $resultado = $claseConexion->queryWithParams("CALL sp_tblNota_SearchNota(:searchTextParam);", array(
            ":searchTextParam" => $searchText
        ));
        $listaNotas = array();
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $objResultado = $this->rowToDto($row);
            $listaNotas[] = $objResultado;
        }
        return $listaNotas;
    }

    function rowToDto($row) {
        $objNota = new Nota();
        $objNota->setId($row["id"]);
        $objNota->setFecha($row["fecha"]);
        $objNota->setTitulo($row["titulo"]);
        $objNota->setNota($row["nota"]);
        $objNota->setEstado($row["estado"]);
        $objNota->setIdCategoria($row["idCategoria"]);
        return $objNota;
    }

}

?>