ALTER TABLE test_table ADD test_attribute;

// --UNDO

ALTER TABLE test_table DROP test_attribute;
