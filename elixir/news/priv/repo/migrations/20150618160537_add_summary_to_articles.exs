defmodule News.Repo.Migrations.AddSummaryToArticles do
  use Ecto.Migration

  def change do
    alter table(:articles) do
      add :summary, :string
    end
  end
end
