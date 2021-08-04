<?php


namespace App\Nova\Service;

use App\Models\Topic;
use App\Models\User;
use App\Nova\Metrics\UserCount;
use App\Nova\Metrics\TopicCount;
use Carbon\Carbon;
use Coroowicaksono\ChartJsIntegration\LineChart;
use Illuminate\Support\Facades\DB;

class CharService
{
    public function getUserWeekChart(): LineChart
    {
        return (new LineChart)
            ->title('用户增长趋势')
            ->animations(
                [
                    'enabled' => true,
                    'easing'  => 'easeinout',
                ]
            )
            ->series(
                array(
                    [
                        'barPercentage' => 0.5,
                        'label'         => implode('-', $this->getLabel(14, 7)),
                        'borderColor'   => '#f7a35c',
                        'data'          => $this->getUserData(14, 7),
                    ],
                    [
                        'barPercentage' => 0.5,
                        'label'         => implode('-', $this->getLabel(7, 1)),
                        'borderColor'   => '#90ed7d',
                        'data'          => $this->getUserData(7, 1)
                    ]
                )
            )
            ->options(
                [
                    'xaxis' => [
                        'categories' => $this->getDays(7),
                    ],
                ]
            )
            ->width('2/3');
    }

    public function getTopicWeekChart()
    {
        return (new LineChart())
            ->title('话题增长趋势1')
            ->animations(
                [
                    'enabled' => true,
                    'easing'  => 'easeinout',
                ]
            )
            ->series(
                array(
                    [
                        'barPercentage' => 0.5,
                        'label'         => implode('-', $this->getLabel(14, 7)),
                        'borderColor'   => '#f7a35c',
                        'data'          => $this->getTopicData(14, 7),
                    ],
                    [
                        'barPercentage' => 0.5,
                        'label'         => implode('-', $this->getLabel(7, 1)),
                        'borderColor'   => '#90ed7d',
                        'data'          => $this->getTopicData(7, 1),
                    ]
                )
            )
            ->options(
                [
                    'xaxis' => [
                        'categories' => $this->getDays(7),
                    ],
                ]
            )
            ->width('2/3');
    }

    private function getLabel($start, $end): array
    {
        return [
            Carbon::now()->subDays($start)->toDateString(),
            Carbon::now()->subDays($end-1)->toDateString()
        ];
    }

    private function getDays(int $before): array
    {
        $daysArr = [];
        for ($i = $before; $i > 0; $i--) {
            $beforeDate = Carbon::today()->subDays($i)->toDateString();
            $daysArr[]  = $beforeDate;
        }

        return $daysArr;
    }

    private function getUserData(int $start, int $end): array
    {
        $dateArr = $this->getDays($start);
        $query   = User::query();
        $query->selectRaw("count(id) as count");
        $query->selectRaw("DATE(created_at) as date");
        $query->whereBetween(
            'created_at',
            $this->getLabel($start, $end)
        );
        $query->groupBy('date');
        $query->pluck('count', 'date');
        $userCount = $query->get()->toArray();
        $data      = $this->formatData($userCount, $dateArr);

        ksort($data);
        return array_values($data);
    }

    private function getTopicData(int $start, int $end): array
    {
        $dateArr = $this->getDays($start);
        $query = Topic::query();
        $query->selectRaw("count(id) as count");
        $query->selectRaw("DATE(created_at) as date");
        $query->whereBetween(
            'created_at',
            $this->getLabel($start, $end)
        );
        $query->groupBy('date');
        $query->pluck('count', 'date');
        $userCount = $query->get()->toArray();
        $data      = $this->formatData($userCount, $dateArr);

        ksort($data);
        return array_values($data);
    }

    private function formatData(array $data, array $dateArr): array
    {
        $result = [];
        $data   = array_column($data, null, 'date');
        foreach ($dateArr as $value) {
            $result[$value] = $data[$value]['count'] ?? 0;
        }

        return $result;
    }


//    public function topicData($before,$end)
//    {
//        $recentDateArr = $this->recentDaysArr($before);
//        $countArr = Topic::recentDaysTopic($this->startEndDate($before,$end));
//        $data = Topic::recentCount($recentDateArr,$countArr);
//        //排序
//        ksort($data);
//        return array_values($data);
//    }
//
//    public function userData($before,$end)
//    {
//        $recentDateArr = $this->recentDaysArr($before);
//        $countArr = User::recentDaysUser($this->startEndDate($before,$end));
//        $data = User::recentCount($recentDateArr,$countArr);
//        //排序
//        ksort($data);
//        return array_values($data);
//    }

}
