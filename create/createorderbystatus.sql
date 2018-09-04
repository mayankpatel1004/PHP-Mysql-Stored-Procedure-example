/*DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CountOrderByStatus`(
 IN orderStatus VARCHAR(25),
 OUT total INT)
BEGIN
 SELECT count(orderNumber)
 INTO total
 FROM orders
 WHERE status = orderStatus;
END$$
DELIMITER ;*/

CALL CountOrderByStatus('Cancelled',@total);
SELECT @total;

/*
Shipped
Resolved
Cancelled
On Hold
Disputed
In Process
*/