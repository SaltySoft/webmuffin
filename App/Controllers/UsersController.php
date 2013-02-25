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

class UsersController extends Controller
{
    function login($params = array())
    {
        if (isset($_POST["name"]) && isset($_POST["password"])) {
            $users = User::where(array("name" => $_POST["name"], "hash" => sha1($_POST["password"])));
            if (count($users) > 0) {
                $user = $users[0];
                $user->login();
            }
        }

        $this->redirect("/");
    }

    function logout($params = array())
    {
        $user = User::current_user();
        if ($user != null) {
            $user->logout();
        }
        $this->redirect("/");
    }


    function login_form()
    {

    }

    function create($params = array())
    {
        $user = new User();
        $usernames = User::where(array("name" => $_POST["name"]));
        $usermail = User::where(array("email" => $_POST["mail"]));
        if (count($usernames) == 0 && count($usermail) == 0)
        {
            $user->setName($_POST["name"]);
            $user->setMail($_POST["mail"]);
            $users = User::where(array("admin" => 1));
            if (count($users) == 0) {
                $user->setAdmin();
            }
            else
            {
                $user->setNormal();
            }

            $user->setHash($_POST["password"]);
            $user->save();
            $user->login();
            $this->redirect("/");
        }
        else
        {
            $this->flash("This user already exists");
            $this->redirect("/Users/login_form");
            //error user exists
        }
    }



    function add($params = array())
    {
        /*
         * This code would keep users to create their own account once an admin has created his account.
         *
        $admin_created = true;
        $user = User::current_user();
        if ($user != null) {
            if (!$user->isAdmin()) {
                $this->redirect("/");
            }

        }
        else
        {
            $users = User::where(array("admin" => 1));
            if (count($users) > 0) {
                $this->redirect("/");
            }
            else
            {
                $admin_created = false;
            }
        }
        $this->set("message", $admin_created);
        */
    }


}
