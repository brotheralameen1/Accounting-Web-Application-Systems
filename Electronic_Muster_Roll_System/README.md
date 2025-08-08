# Introduction

Ever since I left Bug Bounty Hunting for a while, I've pretty much been into accounting and agriculture, since I do have a farm around here, my main objective was to simply digitalize everything to make things a little more easier instead of using complicated books and looking through names to fill up accounts and/or spend the whole day doing accounts on paper while everything can literally be computed straight out of a PC. Everything for salaries was made easier with the implementation of the Digital Muster Roll System that I have created from scratch as you'll see here. 

This Digital Muster Roll System is meant to make your attendance recording much more easier when it comes to taking attendance of workers at your company at any chances possible. This makes things a lot more easier with the ability to compute information much more faster and easier, producing reports and much more, which are basically all in one features of this Web Application itself.

NOTE: I'm currently aware of the Security Risks of using a Password Reset Form that doesn't require an access token, and directly changes the password of an account upon request. This Web Application is specifically designed to be used against a LocalHost and not to be hosted live. Since all activities and works can be done over the LocalHost through XAMPP, I don't think there's necessarily a requirement to have this software hosted online and this risk isn't something to be worried about if you're good with the Operational Security as well. As long as you don't get hacked and the access isn't available online, you're safe. 

However, if you do have concerns about that and actually do want to host this Web Application online, I recommend simply removing the Password Reset link from the Login Page and deleting the /includes/auth/password_reset.php file after resetting the password. However, it'd be a good practice to keep changing a password every week, so I would also recommend keeping a copy of the file before deletion so that once the week is done, you can simply reupload the file and change the password again then delete the file again.

# Features of the Web Application

1. Adding, Deleting, Modifying Shift Information
2. Adding, Deleting, Modifying Employee Information
3. Adding, Deleting, Modifying Loans Information (If you have a company that provides loans to employees that gets reduced from the salary once the loan is given)
4. Adding, Deleting, Modifying Designation Information. NOTE: Designation Information doesn't pertain to wages. All wages are calculated from shifts in this Muster Roll System. However, the implementation of both shifts and designation is necessary for the Web Application to detect a wage. You can put 0 as a wage for designation as well).
5. Accessing Monthly Salary Payroll Report. All payroll reports with deducted loans to help in easy management of payroll during payday.
6. Accessing Daily Salary Reports (This calculates and gives you both a Daily Salary Figure and the Monthly Figure after deducting the loans and adding to the previous balance)
7. Accessing Daily Activity Reports (Reports of every employee everyday including their net salary after loan deduction).

All this can be done with easy computations without the need of using complicated Muster Roll Books since the Digital System makes it much easier for you to manage your tasks. Happy Accounting.
