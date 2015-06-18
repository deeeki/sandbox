defmodule News.Router do
  use News.Web, :router

  pipeline :browser do
    plug :accepts, ["html"]
    plug :fetch_session
    plug :fetch_flash
    plug :protect_from_forgery
  end

  pipeline :api do
    plug :accepts, ["json"]
  end

  scope "/", News do
    pipe_through :browser # Use the default browser stack

    get "/", PageController, :index
    resources "/articles", ArticleController
  end

  # Other scopes may use custom stacks.
  # scope "/api", News do
  #   pipe_through :api
  # end
end
