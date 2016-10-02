use zoodb;

DROP FUNCTION IF EXISTS GetZoo1;
DELIMITER $$

CREATE FUNCTION GetZoo1() RETURNS Text CHARSET utf8
    DETERMINISTIC
    COMMENT 'Zoo animals (1)'
BEGIN
  DECLARE res TEXT CHARSET utf8;
  DECLARE v_name VARCHAR(50) CHARSET utf8;
  DECLARE v_group_name VARCHAR(50) CHARSET utf8;
  DECLARE v_count INT UNSIGNED;
  DECLARE done INT DEFAULT FALSE;
  DECLARE cursorZoo CURSOR FOR select l.name, l.count, g.name from list l join `group` g on g.id = l.group_id;
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
  Set res = Concat('<zoo>\n');
  OPEN cursorZoo;
  read_loop: LOOP
    FETCH cursorZoo INTO v_name, v_count, v_group_name;
    IF done THEN
      LEAVE read_loop;
    END IF;
    SET res = Concat(res, '<animal count="', v_count, '" group="', v_group_name, '">', v_name, '</animal>\n');
  END LOOP;
  CLOSE cursorZoo;
  Set res = Concat(res, '</zoo>');
  RETURN(res);
END;

$$

DELIMITER ;
