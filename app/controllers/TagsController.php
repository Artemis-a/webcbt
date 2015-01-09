<?php
/**
 * The MIT License (MIT)
 *
 * WebCBT - Web based Cognitive Behavioral Therapy tool
 *
 * http://webcbt.github.io
 *
 * Copyright (c) 2014 Prashant Shah <pshah.webcbt@gmail.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

class TagsController extends BaseController {

        public function getIndex()
        {
		$tags = Tag::curuser()->orderBy('name', 'ASC')->get();

                if (!$tags)
                {
                        return Redirect::action('CbtsController@getIndex')
                                ->with('alert-danger', 'Tags not found.');
                }

                return View::make('tags.index')->with('tags', $tags);
        }

        public function getCreate()
        {
                return View::make('tags.create');
        }

        public function postCreate()
        {
                $input = Input::all();

                $input['name'] = ucfirst(strtolower($input['name']));

                $rules = array(
                        'name' => 'required|unique:tags,name',
                        'color' => 'required',
                        'background' => 'required',
                );

                $validator = Validator::make($input, $rules);

                if ($validator->fails())
                {
                        return Redirect::back()->withInput()->withErrors($validator);
                }
                else
                {

                        /* Create a tag */
                        $tag_data = array(
                                'name' => $input['name'],
                                'color' => $input['color'],
                                'background' => $input['background'],
                        );
                        $tag = Tag::create($tag_data);
			if (!$tag)
			{
			        return Redirect::back()->withInput()
                                        ->with('alert-danger', 'Failed to create tag.');
			}

                        return Redirect::action('TagsController@getIndex')
                                ->with('alert-success', 'Tag successfully created.');
                }
        }

        public function getEdit($id)
        {
		$tag = Tag::curuser()->find($id);

                if (!$tag)
                {
                        return Redirect::action('TagsController@getIndex')
                                ->with('alert-danger', 'Tag not found.');
                }

                return View::make('tags.edit')->with('tag', $tag);
        }

        public function postEdit($id)
        {
                $tag = Tag::curuser()->find($id);

                if (!$tag)
                {
                        return Redirect::action('TagsController@getIndex')
                                ->with('alert-danger', 'Tag not found.');
                }

                $input = Input::all();

                $input['name'] = ucfirst(strtolower($input['name']));

                $rules = array(
                        'name' => 'required|unique:tags,name,'.$id,
                );

                $validator = Validator::make($input, $rules);

                if ($validator->fails())
                {
                        return Redirect::back()->withInput()->withErrors($validator);
                }
                else
                {

                        /* Update a tag */
                        $tag->name = $input['name'];
                        $tag->color = $input['color'];
                        $tag->background = $input['background'];
			if (!$tag->save())
			{
			        return Redirect::back()->withInput()
                                        ->with('alert-danger', 'Failed to udpate tag.');
			}

                        return Redirect::action('TagsController@getIndex')
                                ->with('alert-success', 'Tag successfully udpated.');
                }
        }

        public function deleteDestroy($id)
        {
                $tag = Tag::curuser()->find($id);

                if (!$tag)
                {
                        return Redirect::action('TagsController@getIndex')
                                ->with('alert-danger', 'Tag not found.');
                }

                /* Check if tag is already in use */
                $count = Cbt::where('tag_id', '=', $id)->count() > 0;
                if ($count > 0)
                {
                        return Redirect::action('TagsController@getIndex')
                                ->with('alert-danger', 'Failed to delete tag since it is already in use at ' . $count . ' place(s).');
                }

                /* Delete a tag */
		if (!$tag->delete())
		{
		        return Redirect::action('TagsController@getIndex')
                                ->with('alert-danger', 'Failed to delete tag.');
                }

                return Redirect::action('TagsController@getIndex')
                        ->with('alert-success', 'Tag deleted successfully.');
        }
}
