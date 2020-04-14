<?php


namespace App\Services;


use App\Models\CheckedInn;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CheckInnService
{
    /**
     * @var CheckedInn
     */
    protected $model;

    /**
     * CheckInnService constructor.
     * @param CheckedInn $model
     */
    public function __construct(CheckedInn $model)
    {
        $this->model = $model;
    }

    /**
     * @return bool
     */
    public function index()
    {
        if (session()->has('checkedInnId')) {
            $id = session()->get('checkedInnId');
            return CheckedInn::findOrFail($id);
        }
        return false;
    }

    /**
     * @param $inn
     * @return mixed
     */
    public function checkInn($inn)
    {
        $checkedInn = CheckedInn::whereDate('created_at', Carbon::today())->where('inn', $inn)->first();
        if (!$checkedInn) {
            $response = $this->sendCheckInnRequest($inn);
            $resultData = array_merge(['inn' => $inn, 'response_status' => $response->status()], $response->json());
            $checkedInn = DB::transaction(function () use ($resultData) {
                return CheckedInn::create($resultData);
            });
        }
        return $checkedInn;
    }

    /**
     * @param $inn
     * @return \Illuminate\Http\Client\Response
     */
    public function sendCheckInnRequest($inn)
    {
        $response = Http::timeout(60)->post('https://statusnpd.nalog.ru/api/v1/tracker/taxpayer_status', [
            'inn' => $inn,
            'requestDate' => Carbon::today()
        ]);
        return $response;
    }
}
