<?php

namespace App\Http\Controllers\Performance;

use App\Http\Controllers\Controller;
use App\Http\Requests\PerformanceCriteriaRequest;
use App\Model\EmployeePerformanceDetails;
use App\Model\PerformanceCriteria;
use App\Repositories\CommonRepository;
use Illuminate\Support\Facades\Log;

class PerformanceCriteriaController extends Controller
{

    protected $commonRepository;

    public function __construct(CommonRepository $commonRepository)
    {
        $this->commonRepository = $commonRepository;
    }

    public function index()
    {
        $results = PerformanceCriteria::with('category')->get();
        return view('admin.performance.PerformanceCriteria.index', ['results' => $results]);
    }

    public function create()
    {
        $performanceCategory = $this->commonRepository->performanceCategoryList();
        return view('admin.performance.PerformanceCriteria.form', ['performanceCategory' => $performanceCategory]);
    }

    public function store(PerformanceCriteriaRequest $request)
    {
        $input = $request->all();
        try {
            PerformanceCriteria::create($input);
            return ajaxResponse(200, 'Performance criteria Successfully saved.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ajaxResponse(500, 'Internal Server Error');
        }
    }

    public function edit($id)
    {
        $performanceCategory = $this->commonRepository->performanceCategoryList();
        $editModeData        = PerformanceCriteria::FindOrFail($id);
        return view('admin.performance.PerformanceCriteria.form', ['editModeData' => $editModeData, 'performanceCategory' => $performanceCategory]);
    }

    public function update(PerformanceCriteriaRequest $request, $id)
    {
        $data  = PerformanceCriteria::FindOrFail($id);
        $input = $request->all();
        try {
            $data->update($input);
            return ajaxResponse(200, 'Performance criteria Successfully Updated.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ajaxResponse(500, 'Internal Server Error');
        }
    }

    public function destroy($id)
    {

        $count = EmployeePerformanceDetails::where('performance_criteria_id', '=', $id)->count();

        if ($count > 0) {

            return "hasForeignKey";
        }

        try {
            $data = PerformanceCriteria::FindOrFail($id);
            $data->delete();
            $bug = 0;
        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
        }

        if ($bug == 0) {
            echo "success";
        } elseif ($bug == 1451) {
            echo 'hasForeignKey';
        } else {
            echo 'error';
        }
    }

}
