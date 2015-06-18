defmodule News.API.ArticleController do
  use News.Web, :controller

  alias News.Article

  plug :scrub_params, "article" when action in [:create, :update]
  plug :action

  def index(conn, _params) do
    articles = Repo.all(Article)
    render(conn, "index.json", articles: articles)
  end

  def create(conn, %{"article" => article_params}) do
    changeset = Article.changeset(%Article{}, article_params)

    if changeset.valid? do
      article = Repo.insert(changeset)
      render(conn, "show.json", article: article)
    else
      conn
      |> put_status(:unprocessable_entity)
      |> render(News.ChangesetView, "error.json", changeset: changeset)
    end
  end

  def show(conn, %{"id" => id}) do
    article = Repo.get(Article, id)
    render conn, "show.json", article: article
  end

  def update(conn, %{"id" => id, "article" => article_params}) do
    article = Repo.get(Article, id)
    changeset = Article.changeset(article, article_params)

    if changeset.valid? do
      article = Repo.update(changeset)
      render(conn, "show.json", article: article)
    else
      conn
      |> put_status(:unprocessable_entity)
      |> render(News.ChangesetView, "error.json", changeset: changeset)
    end
  end

  def delete(conn, %{"id" => id}) do
    article = Repo.get(Article, id)

    article = Repo.delete(article)
    render(conn, "show.json", article: article)
  end
end
