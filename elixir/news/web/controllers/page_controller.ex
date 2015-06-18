defmodule News.PageController do
  use News.Web, :controller

  plug :action

  def index(conn, _params) do
    render conn, "index.html"
  end
end
