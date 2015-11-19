<?php namespace Education\Http\ViewComposers\Formats\Checklists;

use Illuminate\Contracts\View\View;
use Education\Entities\Category;
use Auth;

class ListComposer {
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {        
        $formats = Auth::user()->company->protocols()->orderBy('updated_at', 'desc')->paginate(20);

        $view->with([
            'formats' => $formats
        ]);
    }
 
}
