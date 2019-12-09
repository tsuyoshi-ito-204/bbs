<?php

use Illuminate\Database\Seeder;
use App\Article;
use App\Comment;
use App\Category;

class ArticleCommentSeeder extends Seeder
{
    public function run()
    {
		$content = 'この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。
					この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。
					この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。
					この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。';
					
		$commentdammy = 'コメントダミーです。ダミーコメントだよ。';
		
		for($i=1; $i<=10; $i++){
			$article = new Article;
			$article->title = "{$i}　番目の投稿";
			$article->content = $content;
			$article->cat_id = 1;
			$article->comment_count = 0;
			$article->save();
			
			$maxComments = mt_rand(3,15);
			for($j=0; $j<=$maxComments; $j++){
				$comment = new Comment;
				$comment->commenter = '名無しさん';
				$comment->comment = $commentdammy;
				$comment->article_id = $article->id;
				$comment->save();
				
				$article->increment('comment_count');
				
				
			}
		}
		
		$cat1 = new Category;
		$cat1->name = '宇宙';
		$cat1->save();
		
		$cat2 = new Category;
		$cat2->name = '温度';
		$cat2->save();
		
    }
}
