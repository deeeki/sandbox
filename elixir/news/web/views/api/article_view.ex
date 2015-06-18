defmodule News.API.ArticleView do
  use News.Web, :view

  def render("index.json", %{articles: articles}) do
    %{data: render_many(articles, News.API.ArticleView, "article.json")}
  end

  def render("show.json", %{article: article}) do
    %{data: render_one(article, News.API.ArticleView, "article.json")}
  end

  def render("article.json", %{article: article}) do
    %{id: article.id}
  end
end
