SET @employee_id := 1;
SELECT * FROM employee em
LEFT JOIN employee_data emd ON (em.id = emd.employee_id)
WHERE em.id = employee_id;

SET @employee_id := 1;
SELECT * FROM employee WHERE id = @employee_id;
SELECT * FROM employee_data WHERE employee_id = @employee_id;