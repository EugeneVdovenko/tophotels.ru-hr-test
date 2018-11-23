/**
 ** Таблица category (id, parent_category_id, name)
 **/

/** вывести корневые директории, начинающиеся на "авто" **/
SELECT
	*
FROM
	`category`
WHERE
	`parent_category_id` IS NULL
	AND `name` LIKE 'авто%'


/** вывести категории, имеющие не более 3-х потомков **/
SELECT
	*
FROM
	category
WHERE
	id IN (
	  /** подзапрос выбирает категории, которрые имеют не более 3-х потомков (т.е. являются родителями не более 3-х раз) **/
	  SELECT
	    parent_category_id AS category_id
    FROM
      `category`
    WHERE
      `parent_category_id` IS NOT NULL
    GROUP BY
      `parent_category_id`
    HAVING
      count( * ) <= 3
)


/** вывести самые нижние категории (которые не имеют потомков, т.е. не являются родителми каких либо подкатегорий) **/
SELECT
	*
FROM
	category
WHERE
	id NOT IN (
	  /** подзапрос выбирает категории, которые являются родителями каких либо подкатегорий **/
		SELECT
			parent_category_id
		FROM
			`category`
		WHERE
			parent_category_id IS NOT NULL
		GROUP BY
			parent_category_id
)


/** какие индексы нужны для ускорения выполнения запросов **/
ALTER TABLE `category`
ADD INDEX `idx`(`parent_category_id`);
