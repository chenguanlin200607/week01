<?php

namespace app\article\controller;

use think\Controller;
use think\Request;
use think\Validate;

class Add extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        return view('index');
    }

    public function add(Request $request)
    {
        $arr['title'] = $request->param('title');
        $arr['describe'] = $request->param('describe');
        $arr['content'] = $request->param('content');
        $validate = new Validate([
            'title' => 'require|max:50',
        ]);
        if (!$validate->check($arr)) {
            $this->error("格式有误");
        }
        $file = request()->file('img');

        // 移动到框架应用根目录/public/uploads/ 目录下
        if ($file) {
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if ($info) {
                // 成功上传后 获取上传信息
                // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                $arr['img'] = $info->getSaveName('img');
            } else {
                // 上传失败获取错误信息
                echo $file->getError();
            }
        }
        $res = \app\article\model\Add::add($arr, $file);
        if ($res) {
            $this->success("添加成功");
        } else {
            $this->error("添加失败");
        }
    }

    public function show()
    {
        $res = \app\article\model\Add::show();
        return view('show', ['arr' => $res]);

    }
    public function tele(Request $request){
        $arr['title'] = $request->param('title');
        $str = \app\article\model\Add::sele($arr['title']);
        if ($str) {
            return view('sele', ['arr' => $str]);
        }
    }
    public function del(Request $request){
        $arr['id']=$request->param('id');
        $res=\app\article\model\Add::del($arr['id']);

        if ($res){
            $this->success('删除成功');
        }
    }
}
