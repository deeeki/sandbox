defmodule News.API.ArticleControllerTest do
  use News.ConnCase

  alias News.Article
  @valid_attrs %{title: "some content", url: "some content"}
  @invalid_attrs %{}

  setup do
    conn = conn() |> put_req_header("accept", "application/json")
    {:ok, conn: conn}
  end

  test "lists all entries on index", %{conn: conn} do
    conn = get conn, article_path(conn, :index)
    assert json_response(conn, 200)["data"] == []
  end

  test "shows chosen resource", %{conn: conn} do
    article = Repo.insert %Article{}
    conn = get conn, article_path(conn, :show, article)
    assert json_response(conn, 200)["data"] == %{
      "id" => article.id
    }
  end

  test "creates and renders resource when data is valid", %{conn: conn} do
    conn = post conn, article_path(conn, :create), article: @valid_attrs
    assert json_response(conn, 200)["data"]["id"]
    assert Repo.get_by(Article, @valid_attrs)
  end

  test "does not create resource and renders errors when data is invalid", %{conn: conn} do
    conn = post conn, article_path(conn, :create), article: @invalid_attrs
    assert json_response(conn, 422)["errors"] != %{}
  end

  test "updates and renders chosen resource when data is valid", %{conn: conn} do
    article = Repo.insert %Article{}
    conn = put conn, article_path(conn, :update, article), article: @valid_attrs
    assert json_response(conn, 200)["data"]["id"]
    assert Repo.get_by(Article, @valid_attrs)
  end

  test "does not update chosen resource and renders errors when data is invalid", %{conn: conn} do
    article = Repo.insert %Article{}
    conn = put conn, article_path(conn, :update, article), article: @invalid_attrs
    assert json_response(conn, 422)["errors"] != %{}
  end

  test "deletes chosen resource", %{conn: conn} do
    article = Repo.insert %Article{}
    conn = delete conn, article_path(conn, :delete, article)
    assert json_response(conn, 200)["data"]["id"]
    refute Repo.get(Article, article.id)
  end
end
