class GoogleDriveSpreadsheet
  class << self
    def write worksheet_title, cell_array
      session = GoogleDrive::Session.from_service_account_key('service_account.json')
      ss = session.spreadsheet_by_key(ENV['SPREADSHEET_KEY'])
      ws = ss.worksheet_by_title(worksheet_title) || ss.add_worksheet(worksheet_title)

      ws.delete_rows(1, ws.num_rows)
      ws.update_cells(1, 1, cell_array)
      ws.save
    end
  end
end
