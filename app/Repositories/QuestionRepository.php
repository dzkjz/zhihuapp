<?php

namespace App\Repositories;

use App\Models\Question;
use App\Topic;

class QuestionRepository
{


    public function all()
    {
        return Question::query()
            ->latest() //排序按照时间
            ->with('user')//带上用户模型 使用懒加载
            ->get();
    }

    public function getQuestionPublished()
    {
        return Question::published()
            ->latest('updated_at') //排序按照更新时间
            ->with('user')//带上用户模型 使用懒加载
            ->get();
    }

    /**
     * 根据提供的数据，使用Eloquent创建question，存储到数据库中并且返回该实例
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $question = Question::create($data);
        return $question;
    }

    /**
     * @param array $topics
     * @return array
     */
    public function normalizeTopics(array $topics)
    {
        //返回topic的id序列，如果不是数字，则强制认为是数据库中的topic的id，
        //这样虽然会漏掉用户如果设置的topic就是数字的情况，但是因为是测试，所以暂时忽略
        $normalizedTopics = collect($topics)->map(function ($topic) {
            if (is_numeric($topic))//是数字
            {
                //在数据库中找id
                $num_topic = Topic::query()->find($topic);
                if (isset($num_topic) && $num_topic->count() > 0) //在数据库中找得到id
                {
                    //因为是找到了 且是从question处提交，其内部的question_count应该增加1个
                    $num_topic->increment('questions_count');
                    //返回id
                    return (int)$num_topic->id;
                }
            }
            //否则创建一个新的topic
            //再之前先判断是否找得到，因为有时候重复提交，select2在提交的数据中不为数字，但是实际上数据库中已经有值
            $already = Topic::query()->select('id', 'name')->where('name', '=', $topic);

            if ($already->count() > 0) {
                //因为是找到了 且是从question处提交，其内部的question_count应该增加1个
                $already->increment('questions_count');
                //返回id
                return $already->first()->id;
            }
            $data_of_topic = [
                'name' => $topic,//目前view中topic只有一个选择框，没有设置content的输入框
                'questions_count' => 1,//因为是找到了 且是从question处提交，其内部的question_count应该初始化为1个
            ];
            //入库
            $newTopic = Topic::create($data_of_topic);
            //返回id
            return $newTopic->id;
        })->toArray();

        return $normalizedTopics;
    }
}
