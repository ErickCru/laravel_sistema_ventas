-- Trigger actualizar stock cuando se ingresan productos
DELIMITER // 
CREATE TRIGGER tr_updStockIngreso AFTER INSERT ON detalle_ingreso 
 FOR EACH ROW BEGIN
 UPDATE articulos SET stock = stock + NEW.cantidad
 WHERE articulos.id = NEW.idarticulo;
END
//
DELIMITER ;

-- Trigger actualizar stock cuando se anula el ingreso de productos
DELIMITER // 
CREATE TRIGGER tr_updStockIngresoAnular AFTER UPDATE ON ingresos FOR EACH ROW 
BEGIN
 UPDATE articulos a 
  JOIN detalle_ingreso di
   ON di.idarticulo = a.id
  AND di.idingreso = NEW.id
  SET a.stock = a.stock - di.cantidad;
END;
//
DELIMITER ;

-- Trigger actualizar stock cuando se venden productos
DELIMITER // 
CREATE TRIGGER tr_updStockVenta AFTER INSERT ON detalle_ventas
 FOR EACH ROW BEGIN
 UPDATE articulos SET stock = stock - NEW.cantidad
 WHERE articulos.id = NEW.idarticulo;
END
//
DELIMITER ;

-- Trigger actualizar stock cuando se anula la venta
DELIMITER // 
CREATE TRIGGER tr_updStockVentaAnular AFTER UPDATE ON ventas FOR EACH ROW 
BEGIN
 UPDATE articulos a 
  JOIN detalle_ventas dv
   ON dv.idarticulo = a.id
  AND dv.idventa = NEW.id
  SET a.stock = a.stock + dv.cantidad;
END;
//
DELIMITER ;