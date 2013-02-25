<?php
/**
 * Copyright (C) 2013 Antoine Jackson
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is furnished
 * to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
 * DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
 * OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE
 * OR OTHER DEALINGS IN THE SOFTWARE.
 */

require_once (ROOT.DS."Config".DS."database.php");
class PagesController extends Controller
{
    function home($params = array())
    {

    }

    /**
     * Delete this function once the application is functional (this is just the config check).
     */
    function configuration($params = array())
    {

        $db_config = new DbConfig;
        $dsn='mysql:host='.$db_config->dev["host"].';port=3306;dbname='.$db_config->dev["database"].'';
        $this->set("database_status", true);
        try {

            $dbh = new PDO($dsn, $db_config->dev["user"], $db_config->dev["password"]);
        } catch (PDOException $exception) {
            $this->set("database_status", false);
        }

        if (extension_loaded("apc"))
        {
            $this->set("apc_set", true);
        }
        else
        {
            $this->set("apc_set", false);
        }

    }

    function e404($params = array())
    {
    }

    function e500($params = array())
    {
    }

    function contact($params = array())
    {
    }


    function list_texts($params = array())
    {
    }

    function block_setup($params = array())
    {
    }

    function setLocale($params = array())
    {
        if (isset($params["locale"]))
        {
            Intl::setLocale($params["locale"]);
        }
        $this->flash("Language changed to " . Intl::getLocale());
        $this->redirect("/");
    }

    function gocontact($params = array())
    {
        $this->flash("sup");
        $this->redirect("/contact");
    }
}
