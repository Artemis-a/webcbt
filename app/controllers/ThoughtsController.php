<?php

class ThoughtsController extends BaseController {

        public function getDispute()
        {
                Auth::loginUsingId(1);

		$data = Cbt::curuser()->orderBy('date', 'DESC')->get();

		if ($data)
		{
                        return View::make('cbts.index')->with('cbts', $data);
		}

        	App::abort(401, 'Failed to fetch data.');
        }
}
