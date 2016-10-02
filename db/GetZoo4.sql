use zoodb;

DROP FUNCTION IF EXISTS GetZoo4;
DELIMITER $$

CREATE FUNCTION GetZoo4(v_sort char(1), 
                        v_group_id INT UNSIGNED,
			v_from INT UNSIGNED, 
                        v_offset INT UNSIGNED) 
          RETURNS Text CHARSET utf8
    DETERMINISTIC
    COMMENT 'Zoo animals (4)'
BEGIN
  DECLARE res TEXT CHARSET utf8;
  DECLARE v_name VARCHAR(50) CHARSET utf8;
  DECLARE v_group_name VARCHAR(50) CHARSET utf8;
  DECLARE v_count INT UNSIGNED;
  DECLARE v_sel_count INT UNSIGNED;
  DECLARE done INT DEFAULT FALSE;
  DECLARE cursorZooN CURSOR FOR 
      select l.name, l.count, g.name from list l join `group` g on g.id = l.group_id
      where (g.id = v_group_id or v_group_id = 0)
	  order by l.name, g.name, l.count
      limit v_from, v_offset;
  DECLARE cursorZooG CURSOR FOR 
      select l.name, l.count, g.name from list l join `group` g on g.id = l.group_id
      where (g.id = v_group_id or v_group_id = 0)
      order by g.name, l.name, l.count
      limit v_from, v_offset;
  DECLARE cursorZooC CURSOR FOR 
      select l.name, l.count, g.name from list l join `group` g on g.id = l.group_id
      where (g.id = v_group_id or v_group_id = 0)
      order by l.count, l.name, g.name
      limit v_from, v_offset;
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
  Set v_sel_count = (select count(l.id) from list l 
                       join `group` g on g.id = l.group_id
                      where (g.id = v_group_id or v_group_id = 0));
  IF v_sort is NULL then
     SET v_sort = 'N';
  END IF;
  Set v_sort = Upper(v_sort);
  IF FIND_IN_SET(v_sort, 'N,G,C') = 0 Then
    SET v_sort = 'N';
  END IF;
  Set res = Concat('<zoo count="', v_sel_count, '">\n');
  CASE v_sort
     WHEN 'N' THEN OPEN cursorZooN;
     WHEN 'G' THEN OPEN cursorZooG;
     WHEN 'C' THEN OPEN cursorZooC;     
  END CASE;
  read_loop: LOOP
	CASE v_sort
       WHEN 'N' THEN FETCH cursorZooN INTO v_name, v_count, v_group_name;
       WHEN 'G' THEN FETCH cursorZooG INTO v_name, v_count, v_group_name;
       WHEN 'C' THEN FETCH cursorZooC INTO v_name, v_count, v_group_name;
	END CASE;
    IF done THEN
      LEAVE read_loop;
    END IF;
    SET res = Concat(res, '<animal count="', v_count, 
                                '" group="', v_group_name, '">',
                               v_name, '</animal>\n');
  END LOOP;
  CASE v_sort
     WHEN 'N' THEN CLOSE cursorZooN;
     WHEN 'G' THEN CLOSE cursorZooG;
     WHEN 'C' THEN CLOSE cursorZooC;     
  END CASE;
  Set res = Concat(res, '</zoo>');
  RETURN(res);
END;

$$

DELIMITER ;
