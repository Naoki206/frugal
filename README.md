# 支出入管理アプリ「FRUGAL」
## URL
https://calm-island-19810.herokuapp.com/home

## 開発環境、言語
OS : MacOS, Linux

ローカル環境: VirtualBox, Vagrant

エディタ : VScode

DBクライアント: PSequel

バージョン管理: Git, Github

開発言語(FW): PHP 8.0.0 Laravel, Framework 6.20.6

## 概要
簡単な月単位の支出入管理アプリです。

一月の出費を、カテゴリ毎に分類し管理し、出費がある度にフォームから情報を入力することで、当月のカテゴリ毎の出費額を一目で把握することができます。

コンセプトは、「最小の労力で最大の貯蓄」です!

### 利用方法

①上限金額と共にカテゴリを作成する。

②TOPページ支出フォームから[金額、名称、カテゴリ]を入力する。

## 機能一覧
- ユーザーは支出カテゴリ作成することができる。(支出カテゴリは名称、上限金額、種類を持つ。)

種類とは「固定日」「変動費」の2種類である。
- ユーザーは支出情報を追加することができる(支出情報はメモ、金額、種類を持つ。)

支出情報は支出カテゴリに分類して管理する。
- ユーザーは支出カテゴリ、支出情報を編集することができる。
- ユーザーごとにアカウントを持ち、ログインしたユーザーは自分のフォルダおよびタスクだけを閲覧または編集することができる。

## ER図
![スクリーンショット 2020-12-18 0.29.15.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/382190/b74fa13b-43ac-8247-f7e5-92731909b362.png)

### こだわったポイント
コンセプトが「最小の労力で最大の貯蓄」ということにもあるように、

貯金、支出入の管理が苦手な人向けに作ったので、何より手軽さを意識しました。

使い方を読まずとも、どんな人でも使えるよう、無駄な機能はとことん排除し、支出入管理のために必要最低限の機能をできるだけわかりやすくデザインしました。

### アドバイスして欲しいポイント
大きくUI/UXデザイン、バックエンドソースの堅実性の2点のアドバイスをいただきたいです。

UI/UXに関する知識が全くないまま、自己流にデザインしてみたので、本来あるべきでないデザイン等が見られる場合はご指摘していただきたいです。

また、バックエンドのソースに関して、あまり誰かに教わったことがないため自己流に書いてしまっていたり堅実なコードが書けていないかもしれないという自覚があるので、もうちょっとこう書くといいよ、といったアドバイスをしていただけると非常に嬉しいです。

### 自己評価
50点

2週間という限られた期間において仕様の作成、実装、デプロイまでやり切れたことに関しては自分でも良かったと思いますが、

十分なデザイン、仕様の検討、デッバグができなかったことや、当初予定していた、「過去の貯金履歴」を確認することができる機能を実装しきれなかった部分などを考慮して50点という評価を自分に与えました。





