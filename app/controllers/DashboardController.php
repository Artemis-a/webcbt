<?php

class DashboardController extends BaseController {

        public function getIndex()
        {
                Auth::loginUsingId(1);

                return View::make('dashboard.index');
        }

}
