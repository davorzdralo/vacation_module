<?php

// TODO: mozda zameniti namespaceovima?

/**
 * This class exists only to group up the constants required to connect to the
 * database. It is an abstract class because it should never be instantiated.
 */
abstract class DbConfig
{
    const HOST = "localhost";
    const DB_NAME = "vacation_module";
    const USERNAME = "root";
    const PASSWORD = "";
}

