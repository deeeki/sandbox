import UIKit

class CartsShowViewController: UIViewController, UITableViewDelegate, UITableViewDataSource {

    var products: [String] = []

    override func viewDidLoad() {
        super.viewDidLoad()
        title = "cart"

        let defaults = NSUserDefaults.standardUserDefaults()
        products = defaults.objectForKey("cart") as [String]

        let closeButton = UIBarButtonItem(barButtonSystemItem: UIBarButtonSystemItem.Stop, target: self, action: "close:")
        navigationItem.leftBarButtonItem = closeButton

        let orderButton = UIButton(frame: CGRectMake(view.bounds.width / 2 - 50, 0, 100, 50))
        orderButton.setTitle("Order", forState: .Normal)
        orderButton.backgroundColor = UIColor.blueColor()
        orderButton.addTarget(self, action: "order:", forControlEvents: .TouchUpInside)
        let footerView = UIView(frame: CGRectMake(0, view.bounds.height - 50, view.bounds.width, 50))
        footerView.backgroundColor = UIColor.grayColor()
        footerView.addSubview(orderButton)
        let tableView = UITableView(frame: view.frame)
        tableView.dataSource = self
        tableView.registerClass(UITableViewCell.self, forCellReuseIdentifier: "cell")

        view.addSubview(tableView)
        view.addSubview(footerView)
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
    }

    func tableView(tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        return products.count
    }

    func tableView(tableView: UITableView, cellForRowAtIndexPath indexPath: NSIndexPath) -> UITableViewCell {
        let cell = tableView.dequeueReusableCellWithIdentifier("cell", forIndexPath: indexPath) as UITableViewCell
        cell.textLabel.text = products[indexPath.row]
        return cell
    }

    func close(sender: AnyObject) {
        dismissViewControllerAnimated(true, completion: nil)
    }

    func order(sender: AnyObject) {
        let defaults = NSUserDefaults.standardUserDefaults()
        defaults.setObject([], forKey: "cart")
        close(self)
    }
}
