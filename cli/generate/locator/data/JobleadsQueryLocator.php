<?php
/**
 * @author Net\Bazzline\Component\Locator
 * @since 2014-06-11
 */

namespace Application\Service;

use AdminGroup;
use AdminGroupQuery;
use AdminUser;
use AdminUserQuery;
use AdminUserGroupRelation;
use AdminUserGroupRelationQuery;
use AdminRight;
use AdminRightQuery;
use AdminRightsCategory;
use AdminRightsCategoryQuery;
use AdminRightRelation;
use AdminRightRelationQuery;
use Affiliate;
use AffiliateQuery;
use AffiliateContact;
use AffiliateContactQuery;
use AffiliateLink;
use AffiliateLinkQuery;
use AffiliateLinkType;
use AffiliateLinkTypeQuery;
use AffiliateUser;
use AffiliateUserQuery;
use ApplicantEmploy;
use ApplicantEmployQuery;
use Application;
use ApplicationQuery;
use ApplicationCommendation;
use ApplicationCommendationQuery;
use ApplicationDocument;
use ApplicationDocumentQuery;
use ApplicationEmployer;
use ApplicationEmployerQuery;
use ApplicationEmployerFunctions;
use ApplicationEmployerFunctionsQuery;
use ApplicationEmployerChannels;
use ApplicationEmployerChannelsQuery;
use ApplicationEngagement;
use ApplicationEngagementQuery;
use ApplicationExpertise;
use ApplicationExpertiseQuery;
use ApplicationCoreCompetence;
use ApplicationCoreCompetenceQuery;
use ApplicationInterest;
use ApplicationInterestQuery;
use ApplicationItknowledge;
use ApplicationItknowledgeQuery;
use ApplicationJobeducation;
use ApplicationJobeducationQuery;
use ApplicationLanguage;
use ApplicationLanguageQuery;
use ApplicationNotice;
use ApplicationNoticeQuery;
use ApplicationPractical;
use ApplicationPracticalQuery;
use ApplicationPracticalFunctions;
use ApplicationPracticalFunctionsQuery;
use ApplicationPracticalChannels;
use ApplicationPracticalChannelsQuery;
use ApplicationTempDocument;
use ApplicationTempDocumentQuery;
use ApplicationStatusHistory;
use ApplicationStatusHistoryQuery;
use ApplicationStatusTypes;
use ApplicationStatusTypesQuery;
use ApplicationStudy;
use ApplicationStudyQuery;
use Article;
use ArticleQuery;
use BranchTemp;
use BranchTempQuery;
use Blacklist;
use BlacklistQuery;
use BlacklistIp;
use BlacklistIpQuery;
use BouncemanagerSettings;
use BouncemanagerSettingsQuery;
use BouncemanagerRules;
use BouncemanagerRulesQuery;
use InterestedHeadhunterMailFlag;
use InterestedHeadhunterMailFlagQuery;
use CandidateSearchbox;
use CandidateSearchboxQuery;
use CandidateSearchCommunication;
use CandidateSearchCommunicationQuery;
use CandidateSearchCommunicationRecommendation;
use CandidateSearchCommunicationRecommendationQuery;
use CandidateSearchNewsletterMailRelation;
use CandidateSearchNewsletterMailRelationQuery;
use CandidateSearchNoticedCandidates;
use CandidateSearchNoticedCandidatesQuery;
use CandidateSearchProfileClick;
use CandidateSearchProfileClickQuery;
use CandidateVisitAggregation;
use CandidateVisitAggregationQuery;
use CareerGoal;
use CareerGoalQuery;
use CareerGoalBranch;
use CareerGoalBranchQuery;
use CareerGoalFunction;
use CareerGoalFunctionQuery;
use Channel;
use ChannelQuery;
use Company;
use CompanyQuery;
use CompanyAdminGroupRelation;
use CompanyAdminGroupRelationQuery;
use CompanyAdminUserRelation;
use CompanyAdminUserRelationQuery;
use CompanyData;
use CompanyDataQuery;
use CompanyDomain;
use CompanyDomainQuery;
use CompanyGroup;
use CompanyGroupQuery;
use CompanyGroupAdminGroupRelation;
use CompanyGroupAdminGroupRelationQuery;
use CompanyGroupAdminUserRelation;
use CompanyGroupAdminUserRelationQuery;
use CompanyGroupRelation;
use CompanyGroupRelationQuery;
use CompanyNotice;
use CompanyNoticeQuery;
use CompanyPrize;
use CompanyPrizeQuery;
use CompanyProfile;
use CompanyProfileQuery;
use CompanyProfileTemplate;
use CompanyProfileTemplateQuery;
use CompanySetting;
use CompanySettingQuery;
use CountryCodes;
use CountryCodesQuery;
use CronjobLog;
use CronjobLogQuery;
use Earning;
use EarningQuery;
use Education;
use EducationQuery;
use ExperienceCompany;
use ExperienceCompanyQuery;
use ExperienceTemp;
use ExperienceTempQuery;
use EmailTemplate;
use EmailTemplateQuery;
use EmailTemplateType;
use EmailTemplateTypeQuery;
use EmvErrorLog;
use EmvErrorLogQuery;
use EmvSyncUser;
use EmvSyncUserQuery;
use ExcludedDomain;
use ExcludedDomainQuery;
use ExcludedEmail;
use ExcludedEmailQuery;
use ExcludedEmailType;
use ExcludedEmailTypeQuery;
use Functions;
use FunctionsQuery;
use Interest;
use InterestQuery;
use Invitation;
use InvitationQuery;
use InvitationCommunityLink;
use InvitationCommunityLinkQuery;
use InvitationLink;
use InvitationLinkQuery;
use InvitationSend;
use InvitationSendQuery;
use Invoice;
use InvoiceQuery;
use InvoiceData;
use InvoiceDataQuery;
use InvoiceTemplate;
use InvoiceTemplateQuery;
use ItknowledgeTypes;
use ItknowledgeTypesQuery;
use JobData;
use JobDataQuery;
use ImportBlacklistDescription;
use ImportBlacklistDescriptionQuery;
use ImportBlacklistName;
use ImportBlacklistNameQuery;
use JobAttribute;
use JobAttributeQuery;
use JobdataForJobmarket;
use JobdataForJobmarketQuery;
use JobmarketExports;
use JobmarketExportsQuery;
use JobClick;
use JobClickQuery;
use JobContracttypes;
use JobContracttypesQuery;
use JobWorkinghour;
use JobWorkinghourQuery;
use JobFunctions;
use JobFunctionsQuery;
use JobHistory;
use JobHistoryQuery;
use JobMarket;
use JobMarketQuery;
use JobRecommendation;
use JobRecommendationQuery;
use JobViewFrontend;
use JobViewFrontendQuery;
use JobZipcodes;
use JobZipcodesQuery;
use JobExtern;
use JobExternQuery;
use JobExternAdministrationEvent;
use JobExternAdministrationEventQuery;
use JobExternFunction;
use JobExternFunctionQuery;
use JobExternHistory;
use JobExternHistoryQuery;
use JobExternReportedOffline;
use JobExternReportedOfflineQuery;
use JobExternSearchengine;
use JobExternSearchengineQuery;
use JobExternStage;
use JobExternStageQuery;
use JobExternStageStatistic;
use JobExternStageStatisticQuery;
use JobExternVerificationActiveStatus;
use JobExternVerificationActiveStatusQuery;
use JobExternParsingStatus;
use JobExternParsingStatusQuery;
use Language;
use LanguageQuery;
use LanguageTypes;
use LanguageTypesQuery;
use LogSearch;
use LogSearchQuery;
use LogSearchParameter;
use LogSearchParameterQuery;
use LogWebservice;
use LogWebserviceQuery;
use Mail;
use MailQuery;
use Menu;
use MenuQuery;
use Message;
use MessageQuery;
use Newsletter;
use NewsletterQuery;
use NewsletterFrontendUser;
use NewsletterFrontendUserQuery;
use NewsletterFrontendUserStats;
use NewsletterFrontendUserStatsQuery;
use NewsletterOpened;
use NewsletterOpenedQuery;
use NewsletterSender;
use NewsletterSenderQuery;
use NewsletterSent;
use NewsletterSentQuery;
use NewsletterTestReceiver;
use NewsletterTestReceiverQuery;
use NewsletterType;
use NewsletterTypeQuery;
use NewsletterUnsubscribed;
use NewsletterUnsubscribedQuery;
use NlAbstractTrackingLink;
use NlAbstractTrackingLinkQuery;
use NlBlock;
use NlBlockQuery;
use NlBlockParam;
use NlBlockParamQuery;
use NlBlockType;
use NlBlockTypeQuery;
use NlCampaign;
use NlCampaignQuery;
use NlCampaignTimingType;
use NlCampaignTimingTypeQuery;
use NlCampaignTimingParam;
use NlCampaignTimingParamQuery;
use NlConcreteTrackingLink;
use NlConcreteTrackingLinkQuery;
use NlConcreteTrackingLinkHit;
use NlConcreteTrackingLinkHitQuery;
use NlJobAlertSent;
use NlJobAlertSentQuery;
use NotificationsLog;
use NotificationsLogQuery;
use Path;
use PathQuery;
use Placeholder;
use PlaceholderQuery;
use PlaceholderGroup;
use PlaceholderGroupQuery;
use PlaceholderToPlaceholderGroup;
use PlaceholderToPlaceholderGroupQuery;
use Premiummodel;
use PremiummodelQuery;
use PremiummodelData;
use PremiummodelDataQuery;
use Prizes;
use PrizesQuery;
use ProfileConfiguration;
use ProfileConfigurationQuery;
use ProfileEmail;
use ProfileEmailQuery;
use ProfileEmailType;
use ProfileEmailTypeQuery;
use ProfileKeyData;
use ProfileKeyDataQuery;
use Recommendation;
use RecommendationQuery;
use RecommendationBasket;
use RecommendationBasketQuery;
use RecommendationSend;
use RecommendationSendQuery;
use Redirect;
use RedirectQuery;
use RegistrationQuery;
use RegistrationQueryQuery;
use RegistrationGoogledata;
use RegistrationGoogledataQuery;
use RegistrationUser;
use RegistrationUserQuery;
use Report;
use ReportQuery;
use ReportAssetFunction;
use ReportAssetFunctionQuery;
use ReportCommon;
use ReportCommonQuery;
use ReportCommonAsset;
use ReportCommonAssetQuery;
use ReportCustom;
use ReportCustomQuery;
use ReportParts;
use ReportPartsQuery;
use ReportPartsAsset;
use ReportPartsAssetQuery;
use SearchagentStatistik;
use SearchagentStatistikQuery;
use StatisticJobmarket;
use StatisticJobmarketQuery;
use StatisticJobmarketDeactivatedJobs;
use StatisticJobmarketDeactivatedJobsQuery;
use StatisticSearchInitial;
use StatisticSearchInitialQuery;
use StatisticSearchRefined;
use StatisticSearchRefinedQuery;
use StatisticsAutomatedExternJobParsing;
use StatisticsAutomatedExternJobParsingQuery;
use StatisticsSaveSearchTeaserPerDay;
use StatisticsSaveSearchTeaserPerDayQuery;
use StatisticsUnresolvedLocationNames;
use StatisticsUnresolvedLocationNamesQuery;
use StudyCertificate;
use StudyCertificateQuery;
use StudyStatus;
use StudyStatusQuery;
use SchoolCertificate;
use SchoolCertificateQuery;
use Translation;
use TranslationQuery;
use University;
use UniversityQuery;
use UniversityCountry;
use UniversityCountryQuery;
use User;
use UserQuery;
use UserAddress;
use UserAddressQuery;
use UserAttribute;
use UserAttributeQuery;
use UserAttributesEmv;
use UserAttributesEmvQuery;
use UserChannel;
use UserChannelQuery;
use UserRedirect;
use UserRedirectQuery;
use UserRegistrationHistory;
use UserRegistrationHistoryQuery;
use UserRole;
use UserRoleQuery;
use UserRoleRessourceRelation;
use UserRoleRessourceRelationQuery;
use UserRoleRessource;
use UserRoleRessourceQuery;
use Academic;
use AcademicQuery;
use Marital;
use MaritalQuery;
use UserContact;
use UserContactQuery;
use UserGroup;
use UserGroupQuery;
use UserIp;
use UserIpQuery;
use UserIpType;
use UserIpTypeQuery;
use UserJobMemo;
use UserJobMemoQuery;
use UserMarketingJob;
use UserMarketingJobQuery;
use UserOrigin;
use UserOriginQuery;
use UserProfileDocument;
use UserProfileDocumentQuery;
use UserProfileCalculation;
use UserProfileCalculationQuery;
use UserProfileCommendation;
use UserProfileCommendationQuery;
use UserProfileEmployer;
use UserProfileEmployerQuery;
use UserProfileEmployerFunctions;
use UserProfileEmployerFunctionsQuery;
use UserProfileEmployerChannels;
use UserProfileEmployerChannelsQuery;
use UserProfileEngagement;
use UserProfileEngagementQuery;
use UserProfileExpertise;
use UserProfileExpertiseQuery;
use UserProfileCoreCompetence;
use UserProfileCoreCompetenceQuery;
use UserProfileItknowledge;
use UserProfileItknowledgeQuery;
use UserProfileInterest;
use UserProfileInterestQuery;
use UserProfileJobeducation;
use UserProfileJobeducationQuery;
use UserProfileLanguage;
use UserProfileLanguageQuery;
use UserProfilePractical;
use UserProfilePracticalQuery;
use UserProfilePracticalFunctions;
use UserProfilePracticalFunctionsQuery;
use UserProfilePracticalChannels;
use UserProfilePracticalChannelsQuery;
use UserProfileStudy;
use UserProfileStudyQuery;
use UserSearchagent;
use UserSearchagentQuery;
use UserSearchagentResultCache;
use UserSearchagentResultCacheQuery;
use UserSearchagentSearch;
use UserSearchagentSearchQuery;
use UserSearchagentSearchParameter;
use UserSearchagentSearchParameterQuery;
use UserSearchagentSended;
use UserSearchagentSendedQuery;
use UserSearchagentSendedJobsIntern;
use UserSearchagentSendedJobsInternQuery;
use UserSearchagentSendedJobsExtern;
use UserSearchagentSendedJobsExternQuery;
use UserSearchagentSendedJobsMail;
use UserSearchagentSendedJobsMailQuery;
use UserTemplate;
use UserTemplateQuery;
use Title;
use TitleQuery;
use UserJobViewed;
use UserJobViewedQuery;
use Voucher;
use VoucherQuery;
use VoucherAddress;
use VoucherAddressQuery;
use VoucherBankData;
use VoucherBankDataQuery;
use VoucherTempMessages;
use VoucherTempMessagesQuery;
use ZipcodesTemp;
use ZipcodesTempQuery;
use JobChannel;
use JobChannelQuery;
use JobExternChannel;
use JobExternChannelQuery;
use CareerGoalChannel;
use CareerGoalChannelQuery;
use MappingFunctionChannel;
use MappingFunctionChannelQuery;
use SearchIndexQueue;
use SearchIndexQueueQuery;
use SearchIndexJob;
use SearchIndexJobQuery;
use PostSalesAddressEvent;
use PostSalesAddressEventQuery;
use UserSelfDeleteEvent;
use UserSelfDeleteEventQuery;
use SavedSearch;
use SavedSearchQuery;
use MappingLocationGeoId;
use MappingLocationGeoIdQuery;
use StatisticsSavedSearchSent;
use StatisticsSavedSearchSentQuery;
use ScheduledTask;
use ScheduledTaskQuery;
use ScheduledTaskParameter;
use ScheduledTaskParameterQuery;
use Event;
use EventQuery;
use EventParameter;
use EventParameterQuery;
use JobLocation;
use JobLocationQuery;
use LocationCity;
use LocationCityQuery;
use LocationRegion;
use LocationRegionQuery;
use MappingIndustryCodeBranch;
use MappingIndustryCodeBranchQuery;
use MappingOperationAreasToChannels;
use MappingOperationAreasToChannelsQuery;
use MappingJobPositionToBenchmark;
use MappingJobPositionToBenchmarkQuery;
use JobExternHash;
use JobExternHashQuery;
use CompanyExtern;
use CompanyExternQuery;
use CompanyExternHash;
use CompanyExternHashQuery;
use CompanyExternBaseUrl;
use CompanyExternBaseUrlQuery;
use CompanyExternBaseUrlBlacklist;
use CompanyExternBaseUrlBlacklistQuery;
use CompanyExternDetails;
use CompanyExternDetailsQuery;
use ChannelToCompanyExtern;
use ChannelToCompanyExternQuery;
use StatisticsUnmatchedJobExternUrl;
use StatisticsUnmatchedJobExternUrlQuery;
use PlannedPregenerationQueue;
use PlannedPregenerationQueueQuery;
use PregeneratedJobChannelXml;
use PregeneratedJobChannelXmlQuery;
use PregeneratedJobLocationXml;
use PregeneratedJobLocationXmlQuery;
use PregeneratedJobExternChannelXml;
use PregeneratedJobExternChannelXmlQuery;
use PregeneratedJobExternLocationXml;
use PregeneratedJobExternLocationXmlQuery;
use PersistentValue;
use PersistentValueQuery;
use CareerLevel;
use CareerLevelQuery;
use CompetenceLevel;
use CompetenceLevelQuery;
use CompetenceExperience;
use CompetenceExperienceQuery;
use BatchjobProcessList;
use BatchjobProcessListQuery;
use BatchjobProcessHistory;
use BatchjobProcessHistoryQuery;
use JobExternVerificationActiveQueue;
use JobExternVerificationActiveQueueQuery;
use JobExternImportQueue;
use JobExternImportQueueQuery;
use UserCalculationProfileCompletenessQueue;
use UserCalculationProfileCompletenessQueueQuery;
use ExperianUserQueue;
use ExperianUserQueueQuery;
use ExperianTopJobQueue;
use ExperianTopJobQueueQuery;
use MigrationProfileCompletenessUpdateHistory;
use MigrationProfileCompletenessUpdateHistoryQuery;
use MigrationUserAddressLog;
use MigrationUserAddressLogQuery;

/**
 * Class JobleadsQueryLocator
 *
 * @package Application\Service
 */
class JobleadsQueryLocator extends AbstractQueryLocator implements JobleadsQueryLocatorInterface
{
    /**
     * @return AdminGroup
     */
    public function createAdminGroup()
    {
        return new AdminGroup();
    }

    /**
     * @return AdminGroupQuery
     */
    public function createAdminGroupQuery()
    {
        return new AdminGroupQuery();
    }

    /**
     * @return AdminUser
     */
    public function createAdminUser()
    {
        return new AdminUser();
    }

    /**
     * @return AdminUserQuery
     */
    public function createAdminUserQuery()
    {
        return new AdminUserQuery();
    }

    /**
     * @return AdminUserGroupRelation
     */
    public function createAdminUserGroupRelation()
    {
        return new AdminUserGroupRelation();
    }

    /**
     * @return AdminUserGroupRelationQuery
     */
    public function createAdminUserGroupRelationQuery()
    {
        return new AdminUserGroupRelationQuery();
    }

    /**
     * @return AdminRight
     */
    public function createAdminRight()
    {
        return new AdminRight();
    }

    /**
     * @return AdminRightQuery
     */
    public function createAdminRightQuery()
    {
        return new AdminRightQuery();
    }

    /**
     * @return AdminRightsCategory
     */
    public function createAdminRightsCategory()
    {
        return new AdminRightsCategory();
    }

    /**
     * @return AdminRightsCategoryQuery
     */
    public function createAdminRightsCategoryQuery()
    {
        return new AdminRightsCategoryQuery();
    }

    /**
     * @return AdminRightRelation
     */
    public function createAdminRightRelation()
    {
        return new AdminRightRelation();
    }

    /**
     * @return AdminRightRelationQuery
     */
    public function createAdminRightRelationQuery()
    {
        return new AdminRightRelationQuery();
    }

    /**
     * @return Affiliate
     */
    public function createAffiliate()
    {
        return new Affiliate();
    }

    /**
     * @return AffiliateQuery
     */
    public function createAffiliateQuery()
    {
        return new AffiliateQuery();
    }

    /**
     * @return AffiliateContact
     */
    public function createAffiliateContact()
    {
        return new AffiliateContact();
    }

    /**
     * @return AffiliateContactQuery
     */
    public function createAffiliateContactQuery()
    {
        return new AffiliateContactQuery();
    }

    /**
     * @return AffiliateLink
     */
    public function createAffiliateLink()
    {
        return new AffiliateLink();
    }

    /**
     * @return AffiliateLinkQuery
     */
    public function createAffiliateLinkQuery()
    {
        return new AffiliateLinkQuery();
    }

    /**
     * @return AffiliateLinkType
     */
    public function createAffiliateLinkType()
    {
        return new AffiliateLinkType();
    }

    /**
     * @return AffiliateLinkTypeQuery
     */
    public function createAffiliateLinkTypeQuery()
    {
        return new AffiliateLinkTypeQuery();
    }

    /**
     * @return AffiliateUser
     */
    public function createAffiliateUser()
    {
        return new AffiliateUser();
    }

    /**
     * @return AffiliateUserQuery
     */
    public function createAffiliateUserQuery()
    {
        return new AffiliateUserQuery();
    }

    /**
     * @return ApplicantEmploy
     */
    public function createApplicantEmploy()
    {
        return new ApplicantEmploy();
    }

    /**
     * @return ApplicantEmployQuery
     */
    public function createApplicantEmployQuery()
    {
        return new ApplicantEmployQuery();
    }

    /**
     * @return Application
     */
    public function createApplication()
    {
        return new Application();
    }

    /**
     * @return ApplicationQuery
     */
    public function createApplicationQuery()
    {
        return new ApplicationQuery();
    }

    /**
     * @return ApplicationCommendation
     */
    public function createApplicationCommendation()
    {
        return new ApplicationCommendation();
    }

    /**
     * @return ApplicationCommendationQuery
     */
    public function createApplicationCommendationQuery()
    {
        return new ApplicationCommendationQuery();
    }

    /**
     * @return ApplicationDocument
     */
    public function createApplicationDocument()
    {
        return new ApplicationDocument();
    }

    /**
     * @return ApplicationDocumentQuery
     */
    public function createApplicationDocumentQuery()
    {
        return new ApplicationDocumentQuery();
    }

    /**
     * @return ApplicationEmployer
     */
    public function createApplicationEmployer()
    {
        return new ApplicationEmployer();
    }

    /**
     * @return ApplicationEmployerQuery
     */
    public function createApplicationEmployerQuery()
    {
        return new ApplicationEmployerQuery();
    }

    /**
     * @return ApplicationEmployerFunctions
     */
    public function createApplicationEmployerFunctions()
    {
        return new ApplicationEmployerFunctions();
    }

    /**
     * @return ApplicationEmployerFunctionsQuery
     */
    public function createApplicationEmployerFunctionsQuery()
    {
        return new ApplicationEmployerFunctionsQuery();
    }

    /**
     * @return ApplicationEmployerChannels
     */
    public function createApplicationEmployerChannels()
    {
        return new ApplicationEmployerChannels();
    }

    /**
     * @return ApplicationEmployerChannelsQuery
     */
    public function createApplicationEmployerChannelsQuery()
    {
        return new ApplicationEmployerChannelsQuery();
    }

    /**
     * @return ApplicationEngagement
     */
    public function createApplicationEngagement()
    {
        return new ApplicationEngagement();
    }

    /**
     * @return ApplicationEngagementQuery
     */
    public function createApplicationEngagementQuery()
    {
        return new ApplicationEngagementQuery();
    }

    /**
     * @return ApplicationExpertise
     */
    public function createApplicationExpertise()
    {
        return new ApplicationExpertise();
    }

    /**
     * @return ApplicationExpertiseQuery
     */
    public function createApplicationExpertiseQuery()
    {
        return new ApplicationExpertiseQuery();
    }

    /**
     * @return ApplicationCoreCompetence
     */
    public function createApplicationCoreCompetence()
    {
        return new ApplicationCoreCompetence();
    }

    /**
     * @return ApplicationCoreCompetenceQuery
     */
    public function createApplicationCoreCompetenceQuery()
    {
        return new ApplicationCoreCompetenceQuery();
    }

    /**
     * @return ApplicationInterest
     */
    public function createApplicationInterest()
    {
        return new ApplicationInterest();
    }

    /**
     * @return ApplicationInterestQuery
     */
    public function createApplicationInterestQuery()
    {
        return new ApplicationInterestQuery();
    }

    /**
     * @return ApplicationItknowledge
     */
    public function createApplicationItknowledge()
    {
        return new ApplicationItknowledge();
    }

    /**
     * @return ApplicationItknowledgeQuery
     */
    public function createApplicationItknowledgeQuery()
    {
        return new ApplicationItknowledgeQuery();
    }

    /**
     * @return ApplicationJobeducation
     */
    public function createApplicationJobeducation()
    {
        return new ApplicationJobeducation();
    }

    /**
     * @return ApplicationJobeducationQuery
     */
    public function createApplicationJobeducationQuery()
    {
        return new ApplicationJobeducationQuery();
    }

    /**
     * @return ApplicationLanguage
     */
    public function createApplicationLanguage()
    {
        return new ApplicationLanguage();
    }

    /**
     * @return ApplicationLanguageQuery
     */
    public function createApplicationLanguageQuery()
    {
        return new ApplicationLanguageQuery();
    }

    /**
     * @return ApplicationNotice
     */
    public function createApplicationNotice()
    {
        return new ApplicationNotice();
    }

    /**
     * @return ApplicationNoticeQuery
     */
    public function createApplicationNoticeQuery()
    {
        return new ApplicationNoticeQuery();
    }

    /**
     * @return ApplicationPractical
     */
    public function createApplicationPractical()
    {
        return new ApplicationPractical();
    }

    /**
     * @return ApplicationPracticalQuery
     */
    public function createApplicationPracticalQuery()
    {
        return new ApplicationPracticalQuery();
    }

    /**
     * @return ApplicationPracticalFunctions
     */
    public function createApplicationPracticalFunctions()
    {
        return new ApplicationPracticalFunctions();
    }

    /**
     * @return ApplicationPracticalFunctionsQuery
     */
    public function createApplicationPracticalFunctionsQuery()
    {
        return new ApplicationPracticalFunctionsQuery();
    }

    /**
     * @return ApplicationPracticalChannels
     */
    public function createApplicationPracticalChannels()
    {
        return new ApplicationPracticalChannels();
    }

    /**
     * @return ApplicationPracticalChannelsQuery
     */
    public function createApplicationPracticalChannelsQuery()
    {
        return new ApplicationPracticalChannelsQuery();
    }

    /**
     * @return ApplicationTempDocument
     */
    public function createApplicationTempDocument()
    {
        return new ApplicationTempDocument();
    }

    /**
     * @return ApplicationTempDocumentQuery
     */
    public function createApplicationTempDocumentQuery()
    {
        return new ApplicationTempDocumentQuery();
    }

    /**
     * @return ApplicationStatusHistory
     */
    public function createApplicationStatusHistory()
    {
        return new ApplicationStatusHistory();
    }

    /**
     * @return ApplicationStatusHistoryQuery
     */
    public function createApplicationStatusHistoryQuery()
    {
        return new ApplicationStatusHistoryQuery();
    }

    /**
     * @return ApplicationStatusTypes
     */
    public function createApplicationStatusTypes()
    {
        return new ApplicationStatusTypes();
    }

    /**
     * @return ApplicationStatusTypesQuery
     */
    public function createApplicationStatusTypesQuery()
    {
        return new ApplicationStatusTypesQuery();
    }

    /**
     * @return ApplicationStudy
     */
    public function createApplicationStudy()
    {
        return new ApplicationStudy();
    }

    /**
     * @return ApplicationStudyQuery
     */
    public function createApplicationStudyQuery()
    {
        return new ApplicationStudyQuery();
    }

    /**
     * @return Article
     */
    public function createArticle()
    {
        return new Article();
    }

    /**
     * @return ArticleQuery
     */
    public function createArticleQuery()
    {
        return new ArticleQuery();
    }

    /**
     * @return BranchTemp
     */
    public function createBranchTemp()
    {
        return new BranchTemp();
    }

    /**
     * @return BranchTempQuery
     */
    public function createBranchTempQuery()
    {
        return new BranchTempQuery();
    }

    /**
     * @return Blacklist
     */
    public function createBlacklist()
    {
        return new Blacklist();
    }

    /**
     * @return BlacklistQuery
     */
    public function createBlacklistQuery()
    {
        return new BlacklistQuery();
    }

    /**
     * @return BlacklistIp
     */
    public function createBlacklistIp()
    {
        return new BlacklistIp();
    }

    /**
     * @return BlacklistIpQuery
     */
    public function createBlacklistIpQuery()
    {
        return new BlacklistIpQuery();
    }

    /**
     * @return BouncemanagerSettings
     */
    public function createBouncemanagerSettings()
    {
        return new BouncemanagerSettings();
    }

    /**
     * @return BouncemanagerSettingsQuery
     */
    public function createBouncemanagerSettingsQuery()
    {
        return new BouncemanagerSettingsQuery();
    }

    /**
     * @return BouncemanagerRules
     */
    public function createBouncemanagerRules()
    {
        return new BouncemanagerRules();
    }

    /**
     * @return BouncemanagerRulesQuery
     */
    public function createBouncemanagerRulesQuery()
    {
        return new BouncemanagerRulesQuery();
    }

    /**
     * @return InterestedHeadhunterMailFlag
     */
    public function createInterestedHeadhunterMailFlag()
    {
        return new InterestedHeadhunterMailFlag();
    }

    /**
     * @return InterestedHeadhunterMailFlagQuery
     */
    public function createInterestedHeadhunterMailFlagQuery()
    {
        return new InterestedHeadhunterMailFlagQuery();
    }

    /**
     * @return CandidateSearchbox
     */
    public function createCandidateSearchbox()
    {
        return new CandidateSearchbox();
    }

    /**
     * @return CandidateSearchboxQuery
     */
    public function createCandidateSearchboxQuery()
    {
        return new CandidateSearchboxQuery();
    }

    /**
     * @return CandidateSearchCommunication
     */
    public function createCandidateSearchCommunication()
    {
        return new CandidateSearchCommunication();
    }

    /**
     * @return CandidateSearchCommunicationQuery
     */
    public function createCandidateSearchCommunicationQuery()
    {
        return new CandidateSearchCommunicationQuery();
    }

    /**
     * @return CandidateSearchCommunicationRecommendation
     */
    public function createCandidateSearchCommunicationRecommendation()
    {
        return new CandidateSearchCommunicationRecommendation();
    }

    /**
     * @return CandidateSearchCommunicationRecommendationQuery
     */
    public function createCandidateSearchCommunicationRecommendationQuery()
    {
        return new CandidateSearchCommunicationRecommendationQuery();
    }

    /**
     * @return CandidateSearchNewsletterMailRelation
     */
    public function createCandidateSearchNewsletterMailRelation()
    {
        return new CandidateSearchNewsletterMailRelation();
    }

    /**
     * @return CandidateSearchNewsletterMailRelationQuery
     */
    public function createCandidateSearchNewsletterMailRelationQuery()
    {
        return new CandidateSearchNewsletterMailRelationQuery();
    }

    /**
     * @return CandidateSearchNoticedCandidates
     */
    public function createCandidateSearchNoticedCandidates()
    {
        return new CandidateSearchNoticedCandidates();
    }

    /**
     * @return CandidateSearchNoticedCandidatesQuery
     */
    public function createCandidateSearchNoticedCandidatesQuery()
    {
        return new CandidateSearchNoticedCandidatesQuery();
    }

    /**
     * @return CandidateSearchProfileClick
     */
    public function createCandidateSearchProfileClick()
    {
        return new CandidateSearchProfileClick();
    }

    /**
     * @return CandidateSearchProfileClickQuery
     */
    public function createCandidateSearchProfileClickQuery()
    {
        return new CandidateSearchProfileClickQuery();
    }

    /**
     * @return CandidateVisitAggregation
     */
    public function createCandidateVisitAggregation()
    {
        return new CandidateVisitAggregation();
    }

    /**
     * @return CandidateVisitAggregationQuery
     */
    public function createCandidateVisitAggregationQuery()
    {
        return new CandidateVisitAggregationQuery();
    }

    /**
     * @return CareerGoal
     */
    public function createCareerGoal()
    {
        return new CareerGoal();
    }

    /**
     * @return CareerGoalQuery
     */
    public function createCareerGoalQuery()
    {
        return new CareerGoalQuery();
    }

    /**
     * @return CareerGoalBranch
     */
    public function createCareerGoalBranch()
    {
        return new CareerGoalBranch();
    }

    /**
     * @return CareerGoalBranchQuery
     */
    public function createCareerGoalBranchQuery()
    {
        return new CareerGoalBranchQuery();
    }

    /**
     * @return CareerGoalFunction
     */
    public function createCareerGoalFunction()
    {
        return new CareerGoalFunction();
    }

    /**
     * @return CareerGoalFunctionQuery
     */
    public function createCareerGoalFunctionQuery()
    {
        return new CareerGoalFunctionQuery();
    }

    /**
     * @return Channel
     */
    public function createChannel()
    {
        return new Channel();
    }

    /**
     * @return ChannelQuery
     */
    public function createChannelQuery()
    {
        return new ChannelQuery();
    }

    /**
     * @return Company
     */
    public function createCompany()
    {
        return new Company();
    }

    /**
     * @return CompanyQuery
     */
    public function createCompanyQuery()
    {
        return new CompanyQuery();
    }

    /**
     * @return CompanyAdminGroupRelation
     */
    public function createCompanyAdminGroupRelation()
    {
        return new CompanyAdminGroupRelation();
    }

    /**
     * @return CompanyAdminGroupRelationQuery
     */
    public function createCompanyAdminGroupRelationQuery()
    {
        return new CompanyAdminGroupRelationQuery();
    }

    /**
     * @return CompanyAdminUserRelation
     */
    public function createCompanyAdminUserRelation()
    {
        return new CompanyAdminUserRelation();
    }

    /**
     * @return CompanyAdminUserRelationQuery
     */
    public function createCompanyAdminUserRelationQuery()
    {
        return new CompanyAdminUserRelationQuery();
    }

    /**
     * @return CompanyData
     */
    public function createCompanyData()
    {
        return new CompanyData();
    }

    /**
     * @return CompanyDataQuery
     */
    public function createCompanyDataQuery()
    {
        return new CompanyDataQuery();
    }

    /**
     * @return CompanyDomain
     */
    public function createCompanyDomain()
    {
        return new CompanyDomain();
    }

    /**
     * @return CompanyDomainQuery
     */
    public function createCompanyDomainQuery()
    {
        return new CompanyDomainQuery();
    }

    /**
     * @return CompanyGroup
     */
    public function createCompanyGroup()
    {
        return new CompanyGroup();
    }

    /**
     * @return CompanyGroupQuery
     */
    public function createCompanyGroupQuery()
    {
        return new CompanyGroupQuery();
    }

    /**
     * @return CompanyGroupAdminGroupRelation
     */
    public function createCompanyGroupAdminGroupRelation()
    {
        return new CompanyGroupAdminGroupRelation();
    }

    /**
     * @return CompanyGroupAdminGroupRelationQuery
     */
    public function createCompanyGroupAdminGroupRelationQuery()
    {
        return new CompanyGroupAdminGroupRelationQuery();
    }

    /**
     * @return CompanyGroupAdminUserRelation
     */
    public function createCompanyGroupAdminUserRelation()
    {
        return new CompanyGroupAdminUserRelation();
    }

    /**
     * @return CompanyGroupAdminUserRelationQuery
     */
    public function createCompanyGroupAdminUserRelationQuery()
    {
        return new CompanyGroupAdminUserRelationQuery();
    }

    /**
     * @return CompanyGroupRelation
     */
    public function createCompanyGroupRelation()
    {
        return new CompanyGroupRelation();
    }

    /**
     * @return CompanyGroupRelationQuery
     */
    public function createCompanyGroupRelationQuery()
    {
        return new CompanyGroupRelationQuery();
    }

    /**
     * @return CompanyNotice
     */
    public function createCompanyNotice()
    {
        return new CompanyNotice();
    }

    /**
     * @return CompanyNoticeQuery
     */
    public function createCompanyNoticeQuery()
    {
        return new CompanyNoticeQuery();
    }

    /**
     * @return CompanyPrize
     */
    public function createCompanyPrize()
    {
        return new CompanyPrize();
    }

    /**
     * @return CompanyPrizeQuery
     */
    public function createCompanyPrizeQuery()
    {
        return new CompanyPrizeQuery();
    }

    /**
     * @return CompanyProfile
     */
    public function createCompanyProfile()
    {
        return new CompanyProfile();
    }

    /**
     * @return CompanyProfileQuery
     */
    public function createCompanyProfileQuery()
    {
        return new CompanyProfileQuery();
    }

    /**
     * @return CompanyProfileTemplate
     */
    public function createCompanyProfileTemplate()
    {
        return new CompanyProfileTemplate();
    }

    /**
     * @return CompanyProfileTemplateQuery
     */
    public function createCompanyProfileTemplateQuery()
    {
        return new CompanyProfileTemplateQuery();
    }

    /**
     * @return CompanySetting
     */
    public function createCompanySetting()
    {
        return new CompanySetting();
    }

    /**
     * @return CompanySettingQuery
     */
    public function createCompanySettingQuery()
    {
        return new CompanySettingQuery();
    }

    /**
     * @return CountryCodes
     */
    public function createCountryCodes()
    {
        return new CountryCodes();
    }

    /**
     * @return CountryCodesQuery
     */
    public function createCountryCodesQuery()
    {
        return new CountryCodesQuery();
    }

    /**
     * @return CronjobLog
     */
    public function createCronjobLog()
    {
        return new CronjobLog();
    }

    /**
     * @return CronjobLogQuery
     */
    public function createCronjobLogQuery()
    {
        return new CronjobLogQuery();
    }

    /**
     * @return Earning
     */
    public function createEarning()
    {
        return new Earning();
    }

    /**
     * @return EarningQuery
     */
    public function createEarningQuery()
    {
        return new EarningQuery();
    }

    /**
     * @return Education
     */
    public function createEducation()
    {
        return new Education();
    }

    /**
     * @return EducationQuery
     */
    public function createEducationQuery()
    {
        return new EducationQuery();
    }

    /**
     * @return ExperienceCompany
     */
    public function createExperienceCompany()
    {
        return new ExperienceCompany();
    }

    /**
     * @return ExperienceCompanyQuery
     */
    public function createExperienceCompanyQuery()
    {
        return new ExperienceCompanyQuery();
    }

    /**
     * @return ExperienceTemp
     */
    public function createExperienceTemp()
    {
        return new ExperienceTemp();
    }

    /**
     * @return ExperienceTempQuery
     */
    public function createExperienceTempQuery()
    {
        return new ExperienceTempQuery();
    }

    /**
     * @return EmailTemplate
     */
    public function createEmailTemplate()
    {
        return new EmailTemplate();
    }

    /**
     * @return EmailTemplateQuery
     */
    public function createEmailTemplateQuery()
    {
        return new EmailTemplateQuery();
    }

    /**
     * @return EmailTemplateType
     */
    public function createEmailTemplateType()
    {
        return new EmailTemplateType();
    }

    /**
     * @return EmailTemplateTypeQuery
     */
    public function createEmailTemplateTypeQuery()
    {
        return new EmailTemplateTypeQuery();
    }

    /**
     * @return EmvErrorLog
     */
    public function createEmvErrorLog()
    {
        return new EmvErrorLog();
    }

    /**
     * @return EmvErrorLogQuery
     */
    public function createEmvErrorLogQuery()
    {
        return new EmvErrorLogQuery();
    }

    /**
     * @return EmvSyncUser
     */
    public function createEmvSyncUser()
    {
        return new EmvSyncUser();
    }

    /**
     * @return EmvSyncUserQuery
     */
    public function createEmvSyncUserQuery()
    {
        return new EmvSyncUserQuery();
    }

    /**
     * @return ExcludedDomain
     */
    public function createExcludedDomain()
    {
        return new ExcludedDomain();
    }

    /**
     * @return ExcludedDomainQuery
     */
    public function createExcludedDomainQuery()
    {
        return new ExcludedDomainQuery();
    }

    /**
     * @return ExcludedEmail
     */
    public function createExcludedEmail()
    {
        return new ExcludedEmail();
    }

    /**
     * @return ExcludedEmailQuery
     */
    public function createExcludedEmailQuery()
    {
        return new ExcludedEmailQuery();
    }

    /**
     * @return ExcludedEmailType
     */
    public function createExcludedEmailType()
    {
        return new ExcludedEmailType();
    }

    /**
     * @return ExcludedEmailTypeQuery
     */
    public function createExcludedEmailTypeQuery()
    {
        return new ExcludedEmailTypeQuery();
    }

    /**
     * @return Functions
     */
    public function createFunctions()
    {
        return new Functions();
    }

    /**
     * @return FunctionsQuery
     */
    public function createFunctionsQuery()
    {
        return new FunctionsQuery();
    }

    /**
     * @return Interest
     */
    public function createInterest()
    {
        return new Interest();
    }

    /**
     * @return InterestQuery
     */
    public function createInterestQuery()
    {
        return new InterestQuery();
    }

    /**
     * @return Invitation
     */
    public function createInvitation()
    {
        return new Invitation();
    }

    /**
     * @return InvitationQuery
     */
    public function createInvitationQuery()
    {
        return new InvitationQuery();
    }

    /**
     * @return InvitationCommunityLink
     */
    public function createInvitationCommunityLink()
    {
        return new InvitationCommunityLink();
    }

    /**
     * @return InvitationCommunityLinkQuery
     */
    public function createInvitationCommunityLinkQuery()
    {
        return new InvitationCommunityLinkQuery();
    }

    /**
     * @return InvitationLink
     */
    public function createInvitationLink()
    {
        return new InvitationLink();
    }

    /**
     * @return InvitationLinkQuery
     */
    public function createInvitationLinkQuery()
    {
        return new InvitationLinkQuery();
    }

    /**
     * @return InvitationSend
     */
    public function createInvitationSend()
    {
        return new InvitationSend();
    }

    /**
     * @return InvitationSendQuery
     */
    public function createInvitationSendQuery()
    {
        return new InvitationSendQuery();
    }

    /**
     * @return Invoice
     */
    public function createInvoice()
    {
        return new Invoice();
    }

    /**
     * @return InvoiceQuery
     */
    public function createInvoiceQuery()
    {
        return new InvoiceQuery();
    }

    /**
     * @return InvoiceData
     */
    public function createInvoiceData()
    {
        return new InvoiceData();
    }

    /**
     * @return InvoiceDataQuery
     */
    public function createInvoiceDataQuery()
    {
        return new InvoiceDataQuery();
    }

    /**
     * @return InvoiceTemplate
     */
    public function createInvoiceTemplate()
    {
        return new InvoiceTemplate();
    }

    /**
     * @return InvoiceTemplateQuery
     */
    public function createInvoiceTemplateQuery()
    {
        return new InvoiceTemplateQuery();
    }

    /**
     * @return ItknowledgeTypes
     */
    public function createItknowledgeTypes()
    {
        return new ItknowledgeTypes();
    }

    /**
     * @return ItknowledgeTypesQuery
     */
    public function createItknowledgeTypesQuery()
    {
        return new ItknowledgeTypesQuery();
    }

    /**
     * @return JobData
     */
    public function createJobData()
    {
        return new JobData();
    }

    /**
     * @return JobDataQuery
     */
    public function createJobDataQuery()
    {
        return new JobDataQuery();
    }

    /**
     * @return ImportBlacklistDescription
     */
    public function createImportBlacklistDescription()
    {
        return new ImportBlacklistDescription();
    }

    /**
     * @return ImportBlacklistDescriptionQuery
     */
    public function createImportBlacklistDescriptionQuery()
    {
        return new ImportBlacklistDescriptionQuery();
    }

    /**
     * @return ImportBlacklistName
     */
    public function createImportBlacklistName()
    {
        return new ImportBlacklistName();
    }

    /**
     * @return ImportBlacklistNameQuery
     */
    public function createImportBlacklistNameQuery()
    {
        return new ImportBlacklistNameQuery();
    }

    /**
     * @return JobAttribute
     */
    public function createJobAttribute()
    {
        return new JobAttribute();
    }

    /**
     * @return JobAttributeQuery
     */
    public function createJobAttributeQuery()
    {
        return new JobAttributeQuery();
    }

    /**
     * @return JobdataForJobmarket
     */
    public function createJobdataForJobmarket()
    {
        return new JobdataForJobmarket();
    }

    /**
     * @return JobdataForJobmarketQuery
     */
    public function createJobdataForJobmarketQuery()
    {
        return new JobdataForJobmarketQuery();
    }

    /**
     * @return JobmarketExports
     */
    public function createJobmarketExports()
    {
        return new JobmarketExports();
    }

    /**
     * @return JobmarketExportsQuery
     */
    public function createJobmarketExportsQuery()
    {
        return new JobmarketExportsQuery();
    }

    /**
     * @return JobClick
     */
    public function createJobClick()
    {
        return new JobClick();
    }

    /**
     * @return JobClickQuery
     */
    public function createJobClickQuery()
    {
        return new JobClickQuery();
    }

    /**
     * @return JobContracttypes
     */
    public function createJobContracttypes()
    {
        return new JobContracttypes();
    }

    /**
     * @return JobContracttypesQuery
     */
    public function createJobContracttypesQuery()
    {
        return new JobContracttypesQuery();
    }

    /**
     * @return JobWorkinghour
     */
    public function createJobWorkinghour()
    {
        return new JobWorkinghour();
    }

    /**
     * @return JobWorkinghourQuery
     */
    public function createJobWorkinghourQuery()
    {
        return new JobWorkinghourQuery();
    }

    /**
     * @return JobFunctions
     */
    public function createJobFunctions()
    {
        return new JobFunctions();
    }

    /**
     * @return JobFunctionsQuery
     */
    public function createJobFunctionsQuery()
    {
        return new JobFunctionsQuery();
    }

    /**
     * @return JobHistory
     */
    public function createJobHistory()
    {
        return new JobHistory();
    }

    /**
     * @return JobHistoryQuery
     */
    public function createJobHistoryQuery()
    {
        return new JobHistoryQuery();
    }

    /**
     * @return JobMarket
     */
    public function createJobMarket()
    {
        return new JobMarket();
    }

    /**
     * @return JobMarketQuery
     */
    public function createJobMarketQuery()
    {
        return new JobMarketQuery();
    }

    /**
     * @return JobRecommendation
     */
    public function createJobRecommendation()
    {
        return new JobRecommendation();
    }

    /**
     * @return JobRecommendationQuery
     */
    public function createJobRecommendationQuery()
    {
        return new JobRecommendationQuery();
    }

    /**
     * @return JobViewFrontend
     */
    public function createJobViewFrontend()
    {
        return new JobViewFrontend();
    }

    /**
     * @return JobViewFrontendQuery
     */
    public function createJobViewFrontendQuery()
    {
        return new JobViewFrontendQuery();
    }

    /**
     * @return JobZipcodes
     */
    public function createJobZipcodes()
    {
        return new JobZipcodes();
    }

    /**
     * @return JobZipcodesQuery
     */
    public function createJobZipcodesQuery()
    {
        return new JobZipcodesQuery();
    }

    /**
     * @return JobExtern
     */
    public function createJobExtern()
    {
        return new JobExtern();
    }

    /**
     * @return JobExternQuery
     */
    public function createJobExternQuery()
    {
        return new JobExternQuery();
    }

    /**
     * @return JobExternAdministrationEvent
     */
    public function createJobExternAdministrationEvent()
    {
        return new JobExternAdministrationEvent();
    }

    /**
     * @return JobExternAdministrationEventQuery
     */
    public function createJobExternAdministrationEventQuery()
    {
        return new JobExternAdministrationEventQuery();
    }

    /**
     * @return JobExternFunction
     */
    public function createJobExternFunction()
    {
        return new JobExternFunction();
    }

    /**
     * @return JobExternFunctionQuery
     */
    public function createJobExternFunctionQuery()
    {
        return new JobExternFunctionQuery();
    }

    /**
     * @return JobExternHistory
     */
    public function createJobExternHistory()
    {
        return new JobExternHistory();
    }

    /**
     * @return JobExternHistoryQuery
     */
    public function createJobExternHistoryQuery()
    {
        return new JobExternHistoryQuery();
    }

    /**
     * @return JobExternReportedOffline
     */
    public function createJobExternReportedOffline()
    {
        return new JobExternReportedOffline();
    }

    /**
     * @return JobExternReportedOfflineQuery
     */
    public function createJobExternReportedOfflineQuery()
    {
        return new JobExternReportedOfflineQuery();
    }

    /**
     * @return JobExternSearchengine
     */
    public function createJobExternSearchengine()
    {
        return new JobExternSearchengine();
    }

    /**
     * @return JobExternSearchengineQuery
     */
    public function createJobExternSearchengineQuery()
    {
        return new JobExternSearchengineQuery();
    }

    /**
     * @return JobExternStage
     */
    public function createJobExternStage()
    {
        return new JobExternStage();
    }

    /**
     * @return JobExternStageQuery
     */
    public function createJobExternStageQuery()
    {
        return new JobExternStageQuery();
    }

    /**
     * @return JobExternStageStatistic
     */
    public function createJobExternStageStatistic()
    {
        return new JobExternStageStatistic();
    }

    /**
     * @return JobExternStageStatisticQuery
     */
    public function createJobExternStageStatisticQuery()
    {
        return new JobExternStageStatisticQuery();
    }

    /**
     * @return JobExternVerificationActiveStatus
     */
    public function createJobExternVerificationActiveStatus()
    {
        return new JobExternVerificationActiveStatus();
    }

    /**
     * @return JobExternVerificationActiveStatusQuery
     */
    public function createJobExternVerificationActiveStatusQuery()
    {
        return new JobExternVerificationActiveStatusQuery();
    }

    /**
     * @return JobExternParsingStatus
     */
    public function createJobExternParsingStatus()
    {
        return new JobExternParsingStatus();
    }

    /**
     * @return JobExternParsingStatusQuery
     */
    public function createJobExternParsingStatusQuery()
    {
        return new JobExternParsingStatusQuery();
    }

    /**
     * @return Language
     */
    public function createLanguage()
    {
        return new Language();
    }

    /**
     * @return LanguageQuery
     */
    public function createLanguageQuery()
    {
        return new LanguageQuery();
    }

    /**
     * @return LanguageTypes
     */
    public function createLanguageTypes()
    {
        return new LanguageTypes();
    }

    /**
     * @return LanguageTypesQuery
     */
    public function createLanguageTypesQuery()
    {
        return new LanguageTypesQuery();
    }

    /**
     * @return LogSearch
     */
    public function createLogSearch()
    {
        return new LogSearch();
    }

    /**
     * @return LogSearchQuery
     */
    public function createLogSearchQuery()
    {
        return new LogSearchQuery();
    }

    /**
     * @return LogSearchParameter
     */
    public function createLogSearchParameter()
    {
        return new LogSearchParameter();
    }

    /**
     * @return LogSearchParameterQuery
     */
    public function createLogSearchParameterQuery()
    {
        return new LogSearchParameterQuery();
    }

    /**
     * @return LogWebservice
     */
    public function createLogWebservice()
    {
        return new LogWebservice();
    }

    /**
     * @return LogWebserviceQuery
     */
    public function createLogWebserviceQuery()
    {
        return new LogWebserviceQuery();
    }

    /**
     * @return Mail
     */
    public function createMail()
    {
        return new Mail();
    }

    /**
     * @return MailQuery
     */
    public function createMailQuery()
    {
        return new MailQuery();
    }

    /**
     * @return Menu
     */
    public function createMenu()
    {
        return new Menu();
    }

    /**
     * @return MenuQuery
     */
    public function createMenuQuery()
    {
        return new MenuQuery();
    }

    /**
     * @return Message
     */
    public function createMessage()
    {
        return new Message();
    }

    /**
     * @return MessageQuery
     */
    public function createMessageQuery()
    {
        return new MessageQuery();
    }

    /**
     * @return Newsletter
     */
    public function createNewsletter()
    {
        return new Newsletter();
    }

    /**
     * @return NewsletterQuery
     */
    public function createNewsletterQuery()
    {
        return new NewsletterQuery();
    }

    /**
     * @return NewsletterFrontendUser
     */
    public function createNewsletterFrontendUser()
    {
        return new NewsletterFrontendUser();
    }

    /**
     * @return NewsletterFrontendUserQuery
     */
    public function createNewsletterFrontendUserQuery()
    {
        return new NewsletterFrontendUserQuery();
    }

    /**
     * @return NewsletterFrontendUserStats
     */
    public function createNewsletterFrontendUserStats()
    {
        return new NewsletterFrontendUserStats();
    }

    /**
     * @return NewsletterFrontendUserStatsQuery
     */
    public function createNewsletterFrontendUserStatsQuery()
    {
        return new NewsletterFrontendUserStatsQuery();
    }

    /**
     * @return NewsletterOpened
     */
    public function createNewsletterOpened()
    {
        return new NewsletterOpened();
    }

    /**
     * @return NewsletterOpenedQuery
     */
    public function createNewsletterOpenedQuery()
    {
        return new NewsletterOpenedQuery();
    }

    /**
     * @return NewsletterSender
     */
    public function createNewsletterSender()
    {
        return new NewsletterSender();
    }

    /**
     * @return NewsletterSenderQuery
     */
    public function createNewsletterSenderQuery()
    {
        return new NewsletterSenderQuery();
    }

    /**
     * @return NewsletterSent
     */
    public function createNewsletterSent()
    {
        return new NewsletterSent();
    }

    /**
     * @return NewsletterSentQuery
     */
    public function createNewsletterSentQuery()
    {
        return new NewsletterSentQuery();
    }

    /**
     * @return NewsletterTestReceiver
     */
    public function createNewsletterTestReceiver()
    {
        return new NewsletterTestReceiver();
    }

    /**
     * @return NewsletterTestReceiverQuery
     */
    public function createNewsletterTestReceiverQuery()
    {
        return new NewsletterTestReceiverQuery();
    }

    /**
     * @return NewsletterType
     */
    public function createNewsletterType()
    {
        return new NewsletterType();
    }

    /**
     * @return NewsletterTypeQuery
     */
    public function createNewsletterTypeQuery()
    {
        return new NewsletterTypeQuery();
    }

    /**
     * @return NewsletterUnsubscribed
     */
    public function createNewsletterUnsubscribed()
    {
        return new NewsletterUnsubscribed();
    }

    /**
     * @return NewsletterUnsubscribedQuery
     */
    public function createNewsletterUnsubscribedQuery()
    {
        return new NewsletterUnsubscribedQuery();
    }

    /**
     * @return NlAbstractTrackingLink
     */
    public function createNlAbstractTrackingLink()
    {
        return new NlAbstractTrackingLink();
    }

    /**
     * @return NlAbstractTrackingLinkQuery
     */
    public function createNlAbstractTrackingLinkQuery()
    {
        return new NlAbstractTrackingLinkQuery();
    }

    /**
     * @return NlBlock
     */
    public function createNlBlock()
    {
        return new NlBlock();
    }

    /**
     * @return NlBlockQuery
     */
    public function createNlBlockQuery()
    {
        return new NlBlockQuery();
    }

    /**
     * @return NlBlockParam
     */
    public function createNlBlockParam()
    {
        return new NlBlockParam();
    }

    /**
     * @return NlBlockParamQuery
     */
    public function createNlBlockParamQuery()
    {
        return new NlBlockParamQuery();
    }

    /**
     * @return NlBlockType
     */
    public function createNlBlockType()
    {
        return new NlBlockType();
    }

    /**
     * @return NlBlockTypeQuery
     */
    public function createNlBlockTypeQuery()
    {
        return new NlBlockTypeQuery();
    }

    /**
     * @return NlCampaign
     */
    public function createNlCampaign()
    {
        return new NlCampaign();
    }

    /**
     * @return NlCampaignQuery
     */
    public function createNlCampaignQuery()
    {
        return new NlCampaignQuery();
    }

    /**
     * @return NlCampaignTimingType
     */
    public function createNlCampaignTimingType()
    {
        return new NlCampaignTimingType();
    }

    /**
     * @return NlCampaignTimingTypeQuery
     */
    public function createNlCampaignTimingTypeQuery()
    {
        return new NlCampaignTimingTypeQuery();
    }

    /**
     * @return NlCampaignTimingParam
     */
    public function createNlCampaignTimingParam()
    {
        return new NlCampaignTimingParam();
    }

    /**
     * @return NlCampaignTimingParamQuery
     */
    public function createNlCampaignTimingParamQuery()
    {
        return new NlCampaignTimingParamQuery();
    }

    /**
     * @return NlConcreteTrackingLink
     */
    public function createNlConcreteTrackingLink()
    {
        return new NlConcreteTrackingLink();
    }

    /**
     * @return NlConcreteTrackingLinkQuery
     */
    public function createNlConcreteTrackingLinkQuery()
    {
        return new NlConcreteTrackingLinkQuery();
    }

    /**
     * @return NlConcreteTrackingLinkHit
     */
    public function createNlConcreteTrackingLinkHit()
    {
        return new NlConcreteTrackingLinkHit();
    }

    /**
     * @return NlConcreteTrackingLinkHitQuery
     */
    public function createNlConcreteTrackingLinkHitQuery()
    {
        return new NlConcreteTrackingLinkHitQuery();
    }

    /**
     * @return NlJobAlertSent
     */
    public function createNlJobAlertSent()
    {
        return new NlJobAlertSent();
    }

    /**
     * @return NlJobAlertSentQuery
     */
    public function createNlJobAlertSentQuery()
    {
        return new NlJobAlertSentQuery();
    }

    /**
     * @return NotificationsLog
     */
    public function createNotificationsLog()
    {
        return new NotificationsLog();
    }

    /**
     * @return NotificationsLogQuery
     */
    public function createNotificationsLogQuery()
    {
        return new NotificationsLogQuery();
    }

    /**
     * @return Path
     */
    public function createPath()
    {
        return new Path();
    }

    /**
     * @return PathQuery
     */
    public function createPathQuery()
    {
        return new PathQuery();
    }

    /**
     * @return Placeholder
     */
    public function createPlaceholder()
    {
        return new Placeholder();
    }

    /**
     * @return PlaceholderQuery
     */
    public function createPlaceholderQuery()
    {
        return new PlaceholderQuery();
    }

    /**
     * @return PlaceholderGroup
     */
    public function createPlaceholderGroup()
    {
        return new PlaceholderGroup();
    }

    /**
     * @return PlaceholderGroupQuery
     */
    public function createPlaceholderGroupQuery()
    {
        return new PlaceholderGroupQuery();
    }

    /**
     * @return PlaceholderToPlaceholderGroup
     */
    public function createPlaceholderToPlaceholderGroup()
    {
        return new PlaceholderToPlaceholderGroup();
    }

    /**
     * @return PlaceholderToPlaceholderGroupQuery
     */
    public function createPlaceholderToPlaceholderGroupQuery()
    {
        return new PlaceholderToPlaceholderGroupQuery();
    }

    /**
     * @return Premiummodel
     */
    public function createPremiummodel()
    {
        return new Premiummodel();
    }

    /**
     * @return PremiummodelQuery
     */
    public function createPremiummodelQuery()
    {
        return new PremiummodelQuery();
    }

    /**
     * @return PremiummodelData
     */
    public function createPremiummodelData()
    {
        return new PremiummodelData();
    }

    /**
     * @return PremiummodelDataQuery
     */
    public function createPremiummodelDataQuery()
    {
        return new PremiummodelDataQuery();
    }

    /**
     * @return Prizes
     */
    public function createPrizes()
    {
        return new Prizes();
    }

    /**
     * @return PrizesQuery
     */
    public function createPrizesQuery()
    {
        return new PrizesQuery();
    }

    /**
     * @return ProfileConfiguration
     */
    public function createProfileConfiguration()
    {
        return new ProfileConfiguration();
    }

    /**
     * @return ProfileConfigurationQuery
     */
    public function createProfileConfigurationQuery()
    {
        return new ProfileConfigurationQuery();
    }

    /**
     * @return ProfileEmail
     */
    public function createProfileEmail()
    {
        return new ProfileEmail();
    }

    /**
     * @return ProfileEmailQuery
     */
    public function createProfileEmailQuery()
    {
        return new ProfileEmailQuery();
    }

    /**
     * @return ProfileEmailType
     */
    public function createProfileEmailType()
    {
        return new ProfileEmailType();
    }

    /**
     * @return ProfileEmailTypeQuery
     */
    public function createProfileEmailTypeQuery()
    {
        return new ProfileEmailTypeQuery();
    }

    /**
     * @return ProfileKeyData
     */
    public function createProfileKeyData()
    {
        return new ProfileKeyData();
    }

    /**
     * @return ProfileKeyDataQuery
     */
    public function createProfileKeyDataQuery()
    {
        return new ProfileKeyDataQuery();
    }

    /**
     * @return Recommendation
     */
    public function createRecommendation()
    {
        return new Recommendation();
    }

    /**
     * @return RecommendationQuery
     */
    public function createRecommendationQuery()
    {
        return new RecommendationQuery();
    }

    /**
     * @return RecommendationBasket
     */
    public function createRecommendationBasket()
    {
        return new RecommendationBasket();
    }

    /**
     * @return RecommendationBasketQuery
     */
    public function createRecommendationBasketQuery()
    {
        return new RecommendationBasketQuery();
    }

    /**
     * @return RecommendationSend
     */
    public function createRecommendationSend()
    {
        return new RecommendationSend();
    }

    /**
     * @return RecommendationSendQuery
     */
    public function createRecommendationSendQuery()
    {
        return new RecommendationSendQuery();
    }

    /**
     * @return Redirect
     */
    public function createRedirect()
    {
        return new Redirect();
    }

    /**
     * @return RedirectQuery
     */
    public function createRedirectQuery()
    {
        return new RedirectQuery();
    }

    /**
     * @return RegistrationQuery
     */
    public function createRegistrationQuery()
    {
        return new RegistrationQuery();
    }

    /**
     * @return RegistrationQueryQuery
     */
    public function createRegistrationQueryQuery()
    {
        return new RegistrationQueryQuery();
    }

    /**
     * @return RegistrationGoogledata
     */
    public function createRegistrationGoogledata()
    {
        return new RegistrationGoogledata();
    }

    /**
     * @return RegistrationGoogledataQuery
     */
    public function createRegistrationGoogledataQuery()
    {
        return new RegistrationGoogledataQuery();
    }

    /**
     * @return RegistrationUser
     */
    public function createRegistrationUser()
    {
        return new RegistrationUser();
    }

    /**
     * @return RegistrationUserQuery
     */
    public function createRegistrationUserQuery()
    {
        return new RegistrationUserQuery();
    }

    /**
     * @return Report
     */
    public function createReport()
    {
        return new Report();
    }

    /**
     * @return ReportQuery
     */
    public function createReportQuery()
    {
        return new ReportQuery();
    }

    /**
     * @return ReportAssetFunction
     */
    public function createReportAssetFunction()
    {
        return new ReportAssetFunction();
    }

    /**
     * @return ReportAssetFunctionQuery
     */
    public function createReportAssetFunctionQuery()
    {
        return new ReportAssetFunctionQuery();
    }

    /**
     * @return ReportCommon
     */
    public function createReportCommon()
    {
        return new ReportCommon();
    }

    /**
     * @return ReportCommonQuery
     */
    public function createReportCommonQuery()
    {
        return new ReportCommonQuery();
    }

    /**
     * @return ReportCommonAsset
     */
    public function createReportCommonAsset()
    {
        return new ReportCommonAsset();
    }

    /**
     * @return ReportCommonAssetQuery
     */
    public function createReportCommonAssetQuery()
    {
        return new ReportCommonAssetQuery();
    }

    /**
     * @return ReportCustom
     */
    public function createReportCustom()
    {
        return new ReportCustom();
    }

    /**
     * @return ReportCustomQuery
     */
    public function createReportCustomQuery()
    {
        return new ReportCustomQuery();
    }

    /**
     * @return ReportParts
     */
    public function createReportParts()
    {
        return new ReportParts();
    }

    /**
     * @return ReportPartsQuery
     */
    public function createReportPartsQuery()
    {
        return new ReportPartsQuery();
    }

    /**
     * @return ReportPartsAsset
     */
    public function createReportPartsAsset()
    {
        return new ReportPartsAsset();
    }

    /**
     * @return ReportPartsAssetQuery
     */
    public function createReportPartsAssetQuery()
    {
        return new ReportPartsAssetQuery();
    }

    /**
     * @return SearchagentStatistik
     */
    public function createSearchagentStatistik()
    {
        return new SearchagentStatistik();
    }

    /**
     * @return SearchagentStatistikQuery
     */
    public function createSearchagentStatistikQuery()
    {
        return new SearchagentStatistikQuery();
    }

    /**
     * @return StatisticJobmarket
     */
    public function createStatisticJobmarket()
    {
        return new StatisticJobmarket();
    }

    /**
     * @return StatisticJobmarketQuery
     */
    public function createStatisticJobmarketQuery()
    {
        return new StatisticJobmarketQuery();
    }

    /**
     * @return StatisticJobmarketDeactivatedJobs
     */
    public function createStatisticJobmarketDeactivatedJobs()
    {
        return new StatisticJobmarketDeactivatedJobs();
    }

    /**
     * @return StatisticJobmarketDeactivatedJobsQuery
     */
    public function createStatisticJobmarketDeactivatedJobsQuery()
    {
        return new StatisticJobmarketDeactivatedJobsQuery();
    }

    /**
     * @return StatisticSearchInitial
     */
    public function createStatisticSearchInitial()
    {
        return new StatisticSearchInitial();
    }

    /**
     * @return StatisticSearchInitialQuery
     */
    public function createStatisticSearchInitialQuery()
    {
        return new StatisticSearchInitialQuery();
    }

    /**
     * @return StatisticSearchRefined
     */
    public function createStatisticSearchRefined()
    {
        return new StatisticSearchRefined();
    }

    /**
     * @return StatisticSearchRefinedQuery
     */
    public function createStatisticSearchRefinedQuery()
    {
        return new StatisticSearchRefinedQuery();
    }

    /**
     * @return StatisticsAutomatedExternJobParsing
     */
    public function createStatisticsAutomatedExternJobParsing()
    {
        return new StatisticsAutomatedExternJobParsing();
    }

    /**
     * @return StatisticsAutomatedExternJobParsingQuery
     */
    public function createStatisticsAutomatedExternJobParsingQuery()
    {
        return new StatisticsAutomatedExternJobParsingQuery();
    }

    /**
     * @return StatisticsSaveSearchTeaserPerDay
     */
    public function createStatisticsSaveSearchTeaserPerDay()
    {
        return new StatisticsSaveSearchTeaserPerDay();
    }

    /**
     * @return StatisticsSaveSearchTeaserPerDayQuery
     */
    public function createStatisticsSaveSearchTeaserPerDayQuery()
    {
        return new StatisticsSaveSearchTeaserPerDayQuery();
    }

    /**
     * @return StatisticsUnresolvedLocationNames
     */
    public function createStatisticsUnresolvedLocationNames()
    {
        return new StatisticsUnresolvedLocationNames();
    }

    /**
     * @return StatisticsUnresolvedLocationNamesQuery
     */
    public function createStatisticsUnresolvedLocationNamesQuery()
    {
        return new StatisticsUnresolvedLocationNamesQuery();
    }

    /**
     * @return StudyCertificate
     */
    public function createStudyCertificate()
    {
        return new StudyCertificate();
    }

    /**
     * @return StudyCertificateQuery
     */
    public function createStudyCertificateQuery()
    {
        return new StudyCertificateQuery();
    }

    /**
     * @return StudyStatus
     */
    public function createStudyStatus()
    {
        return new StudyStatus();
    }

    /**
     * @return StudyStatusQuery
     */
    public function createStudyStatusQuery()
    {
        return new StudyStatusQuery();
    }

    /**
     * @return SchoolCertificate
     */
    public function createSchoolCertificate()
    {
        return new SchoolCertificate();
    }

    /**
     * @return SchoolCertificateQuery
     */
    public function createSchoolCertificateQuery()
    {
        return new SchoolCertificateQuery();
    }

    /**
     * @return Translation
     */
    public function createTranslation()
    {
        return new Translation();
    }

    /**
     * @return TranslationQuery
     */
    public function createTranslationQuery()
    {
        return new TranslationQuery();
    }

    /**
     * @return University
     */
    public function createUniversity()
    {
        return new University();
    }

    /**
     * @return UniversityQuery
     */
    public function createUniversityQuery()
    {
        return new UniversityQuery();
    }

    /**
     * @return UniversityCountry
     */
    public function createUniversityCountry()
    {
        return new UniversityCountry();
    }

    /**
     * @return UniversityCountryQuery
     */
    public function createUniversityCountryQuery()
    {
        return new UniversityCountryQuery();
    }

    /**
     * @return User
     */
    public function createUser()
    {
        return new User();
    }

    /**
     * @return UserQuery
     */
    public function createUserQuery()
    {
        return new UserQuery();
    }

    /**
     * @return UserAddress
     */
    public function createUserAddress()
    {
        return new UserAddress();
    }

    /**
     * @return UserAddressQuery
     */
    public function createUserAddressQuery()
    {
        return new UserAddressQuery();
    }

    /**
     * @return UserAttribute
     */
    public function createUserAttribute()
    {
        return new UserAttribute();
    }

    /**
     * @return UserAttributeQuery
     */
    public function createUserAttributeQuery()
    {
        return new UserAttributeQuery();
    }

    /**
     * @return UserAttributesEmv
     */
    public function createUserAttributesEmv()
    {
        return new UserAttributesEmv();
    }

    /**
     * @return UserAttributesEmvQuery
     */
    public function createUserAttributesEmvQuery()
    {
        return new UserAttributesEmvQuery();
    }

    /**
     * @return UserChannel
     */
    public function createUserChannel()
    {
        return new UserChannel();
    }

    /**
     * @return UserChannelQuery
     */
    public function createUserChannelQuery()
    {
        return new UserChannelQuery();
    }

    /**
     * @return UserRedirect
     */
    public function createUserRedirect()
    {
        return new UserRedirect();
    }

    /**
     * @return UserRedirectQuery
     */
    public function createUserRedirectQuery()
    {
        return new UserRedirectQuery();
    }

    /**
     * @return UserRegistrationHistory
     */
    public function createUserRegistrationHistory()
    {
        return new UserRegistrationHistory();
    }

    /**
     * @return UserRegistrationHistoryQuery
     */
    public function createUserRegistrationHistoryQuery()
    {
        return new UserRegistrationHistoryQuery();
    }

    /**
     * @return UserRole
     */
    public function createUserRole()
    {
        return new UserRole();
    }

    /**
     * @return UserRoleQuery
     */
    public function createUserRoleQuery()
    {
        return new UserRoleQuery();
    }

    /**
     * @return UserRoleRessourceRelation
     */
    public function createUserRoleRessourceRelation()
    {
        return new UserRoleRessourceRelation();
    }

    /**
     * @return UserRoleRessourceRelationQuery
     */
    public function createUserRoleRessourceRelationQuery()
    {
        return new UserRoleRessourceRelationQuery();
    }

    /**
     * @return UserRoleRessource
     */
    public function createUserRoleRessource()
    {
        return new UserRoleRessource();
    }

    /**
     * @return UserRoleRessourceQuery
     */
    public function createUserRoleRessourceQuery()
    {
        return new UserRoleRessourceQuery();
    }

    /**
     * @return Academic
     */
    public function createAcademic()
    {
        return new Academic();
    }

    /**
     * @return AcademicQuery
     */
    public function createAcademicQuery()
    {
        return new AcademicQuery();
    }

    /**
     * @return Marital
     */
    public function createMarital()
    {
        return new Marital();
    }

    /**
     * @return MaritalQuery
     */
    public function createMaritalQuery()
    {
        return new MaritalQuery();
    }

    /**
     * @return UserContact
     */
    public function createUserContact()
    {
        return new UserContact();
    }

    /**
     * @return UserContactQuery
     */
    public function createUserContactQuery()
    {
        return new UserContactQuery();
    }

    /**
     * @return UserGroup
     */
    public function createUserGroup()
    {
        return new UserGroup();
    }

    /**
     * @return UserGroupQuery
     */
    public function createUserGroupQuery()
    {
        return new UserGroupQuery();
    }

    /**
     * @return UserIp
     */
    public function createUserIp()
    {
        return new UserIp();
    }

    /**
     * @return UserIpQuery
     */
    public function createUserIpQuery()
    {
        return new UserIpQuery();
    }

    /**
     * @return UserIpType
     */
    public function createUserIpType()
    {
        return new UserIpType();
    }

    /**
     * @return UserIpTypeQuery
     */
    public function createUserIpTypeQuery()
    {
        return new UserIpTypeQuery();
    }

    /**
     * @return UserJobMemo
     */
    public function createUserJobMemo()
    {
        return new UserJobMemo();
    }

    /**
     * @return UserJobMemoQuery
     */
    public function createUserJobMemoQuery()
    {
        return new UserJobMemoQuery();
    }

    /**
     * @return UserMarketingJob
     */
    public function createUserMarketingJob()
    {
        return new UserMarketingJob();
    }

    /**
     * @return UserMarketingJobQuery
     */
    public function createUserMarketingJobQuery()
    {
        return new UserMarketingJobQuery();
    }

    /**
     * @return UserOrigin
     */
    public function createUserOrigin()
    {
        return new UserOrigin();
    }

    /**
     * @return UserOriginQuery
     */
    public function createUserOriginQuery()
    {
        return new UserOriginQuery();
    }

    /**
     * @return UserProfileDocument
     */
    public function createUserProfileDocument()
    {
        return new UserProfileDocument();
    }

    /**
     * @return UserProfileDocumentQuery
     */
    public function createUserProfileDocumentQuery()
    {
        return new UserProfileDocumentQuery();
    }

    /**
     * @return UserProfileCalculation
     */
    public function createUserProfileCalculation()
    {
        return new UserProfileCalculation();
    }

    /**
     * @return UserProfileCalculationQuery
     */
    public function createUserProfileCalculationQuery()
    {
        return new UserProfileCalculationQuery();
    }

    /**
     * @return UserProfileCommendation
     */
    public function createUserProfileCommendation()
    {
        return new UserProfileCommendation();
    }

    /**
     * @return UserProfileCommendationQuery
     */
    public function createUserProfileCommendationQuery()
    {
        return new UserProfileCommendationQuery();
    }

    /**
     * @return UserProfileEmployer
     */
    public function createUserProfileEmployer()
    {
        return new UserProfileEmployer();
    }

    /**
     * @return UserProfileEmployerQuery
     */
    public function createUserProfileEmployerQuery()
    {
        return new UserProfileEmployerQuery();
    }

    /**
     * @return UserProfileEmployerFunctions
     */
    public function createUserProfileEmployerFunctions()
    {
        return new UserProfileEmployerFunctions();
    }

    /**
     * @return UserProfileEmployerFunctionsQuery
     */
    public function createUserProfileEmployerFunctionsQuery()
    {
        return new UserProfileEmployerFunctionsQuery();
    }

    /**
     * @return UserProfileEmployerChannels
     */
    public function createUserProfileEmployerChannels()
    {
        return new UserProfileEmployerChannels();
    }

    /**
     * @return UserProfileEmployerChannelsQuery
     */
    public function createUserProfileEmployerChannelsQuery()
    {
        return new UserProfileEmployerChannelsQuery();
    }

    /**
     * @return UserProfileEngagement
     */
    public function createUserProfileEngagement()
    {
        return new UserProfileEngagement();
    }

    /**
     * @return UserProfileEngagementQuery
     */
    public function createUserProfileEngagementQuery()
    {
        return new UserProfileEngagementQuery();
    }

    /**
     * @return UserProfileExpertise
     */
    public function createUserProfileExpertise()
    {
        return new UserProfileExpertise();
    }

    /**
     * @return UserProfileExpertiseQuery
     */
    public function createUserProfileExpertiseQuery()
    {
        return new UserProfileExpertiseQuery();
    }

    /**
     * @return UserProfileCoreCompetence
     */
    public function createUserProfileCoreCompetence()
    {
        return new UserProfileCoreCompetence();
    }

    /**
     * @return UserProfileCoreCompetenceQuery
     */
    public function createUserProfileCoreCompetenceQuery()
    {
        return new UserProfileCoreCompetenceQuery();
    }

    /**
     * @return UserProfileItknowledge
     */
    public function createUserProfileItknowledge()
    {
        return new UserProfileItknowledge();
    }

    /**
     * @return UserProfileItknowledgeQuery
     */
    public function createUserProfileItknowledgeQuery()
    {
        return new UserProfileItknowledgeQuery();
    }

    /**
     * @return UserProfileInterest
     */
    public function createUserProfileInterest()
    {
        return new UserProfileInterest();
    }

    /**
     * @return UserProfileInterestQuery
     */
    public function createUserProfileInterestQuery()
    {
        return new UserProfileInterestQuery();
    }

    /**
     * @return UserProfileJobeducation
     */
    public function createUserProfileJobeducation()
    {
        return new UserProfileJobeducation();
    }

    /**
     * @return UserProfileJobeducationQuery
     */
    public function createUserProfileJobeducationQuery()
    {
        return new UserProfileJobeducationQuery();
    }

    /**
     * @return UserProfileLanguage
     */
    public function createUserProfileLanguage()
    {
        return new UserProfileLanguage();
    }

    /**
     * @return UserProfileLanguageQuery
     */
    public function createUserProfileLanguageQuery()
    {
        return new UserProfileLanguageQuery();
    }

    /**
     * @return UserProfilePractical
     */
    public function createUserProfilePractical()
    {
        return new UserProfilePractical();
    }

    /**
     * @return UserProfilePracticalQuery
     */
    public function createUserProfilePracticalQuery()
    {
        return new UserProfilePracticalQuery();
    }

    /**
     * @return UserProfilePracticalFunctions
     */
    public function createUserProfilePracticalFunctions()
    {
        return new UserProfilePracticalFunctions();
    }

    /**
     * @return UserProfilePracticalFunctionsQuery
     */
    public function createUserProfilePracticalFunctionsQuery()
    {
        return new UserProfilePracticalFunctionsQuery();
    }

    /**
     * @return UserProfilePracticalChannels
     */
    public function createUserProfilePracticalChannels()
    {
        return new UserProfilePracticalChannels();
    }

    /**
     * @return UserProfilePracticalChannelsQuery
     */
    public function createUserProfilePracticalChannelsQuery()
    {
        return new UserProfilePracticalChannelsQuery();
    }

    /**
     * @return UserProfileStudy
     */
    public function createUserProfileStudy()
    {
        return new UserProfileStudy();
    }

    /**
     * @return UserProfileStudyQuery
     */
    public function createUserProfileStudyQuery()
    {
        return new UserProfileStudyQuery();
    }

    /**
     * @return UserSearchagent
     */
    public function createUserSearchagent()
    {
        return new UserSearchagent();
    }

    /**
     * @return UserSearchagentQuery
     */
    public function createUserSearchagentQuery()
    {
        return new UserSearchagentQuery();
    }

    /**
     * @return UserSearchagentResultCache
     */
    public function createUserSearchagentResultCache()
    {
        return new UserSearchagentResultCache();
    }

    /**
     * @return UserSearchagentResultCacheQuery
     */
    public function createUserSearchagentResultCacheQuery()
    {
        return new UserSearchagentResultCacheQuery();
    }

    /**
     * @return UserSearchagentSearch
     */
    public function createUserSearchagentSearch()
    {
        return new UserSearchagentSearch();
    }

    /**
     * @return UserSearchagentSearchQuery
     */
    public function createUserSearchagentSearchQuery()
    {
        return new UserSearchagentSearchQuery();
    }

    /**
     * @return UserSearchagentSearchParameter
     */
    public function createUserSearchagentSearchParameter()
    {
        return new UserSearchagentSearchParameter();
    }

    /**
     * @return UserSearchagentSearchParameterQuery
     */
    public function createUserSearchagentSearchParameterQuery()
    {
        return new UserSearchagentSearchParameterQuery();
    }

    /**
     * @return UserSearchagentSended
     */
    public function createUserSearchagentSended()
    {
        return new UserSearchagentSended();
    }

    /**
     * @return UserSearchagentSendedQuery
     */
    public function createUserSearchagentSendedQuery()
    {
        return new UserSearchagentSendedQuery();
    }

    /**
     * @return UserSearchagentSendedJobsIntern
     */
    public function createUserSearchagentSendedJobsIntern()
    {
        return new UserSearchagentSendedJobsIntern();
    }

    /**
     * @return UserSearchagentSendedJobsInternQuery
     */
    public function createUserSearchagentSendedJobsInternQuery()
    {
        return new UserSearchagentSendedJobsInternQuery();
    }

    /**
     * @return UserSearchagentSendedJobsExtern
     */
    public function createUserSearchagentSendedJobsExtern()
    {
        return new UserSearchagentSendedJobsExtern();
    }

    /**
     * @return UserSearchagentSendedJobsExternQuery
     */
    public function createUserSearchagentSendedJobsExternQuery()
    {
        return new UserSearchagentSendedJobsExternQuery();
    }

    /**
     * @return UserSearchagentSendedJobsMail
     */
    public function createUserSearchagentSendedJobsMail()
    {
        return new UserSearchagentSendedJobsMail();
    }

    /**
     * @return UserSearchagentSendedJobsMailQuery
     */
    public function createUserSearchagentSendedJobsMailQuery()
    {
        return new UserSearchagentSendedJobsMailQuery();
    }

    /**
     * @return UserTemplate
     */
    public function createUserTemplate()
    {
        return new UserTemplate();
    }

    /**
     * @return UserTemplateQuery
     */
    public function createUserTemplateQuery()
    {
        return new UserTemplateQuery();
    }

    /**
     * @return Title
     */
    public function createTitle()
    {
        return new Title();
    }

    /**
     * @return TitleQuery
     */
    public function createTitleQuery()
    {
        return new TitleQuery();
    }

    /**
     * @return UserJobViewed
     */
    public function createUserJobViewed()
    {
        return new UserJobViewed();
    }

    /**
     * @return UserJobViewedQuery
     */
    public function createUserJobViewedQuery()
    {
        return new UserJobViewedQuery();
    }

    /**
     * @return Voucher
     */
    public function createVoucher()
    {
        return new Voucher();
    }

    /**
     * @return VoucherQuery
     */
    public function createVoucherQuery()
    {
        return new VoucherQuery();
    }

    /**
     * @return VoucherAddress
     */
    public function createVoucherAddress()
    {
        return new VoucherAddress();
    }

    /**
     * @return VoucherAddressQuery
     */
    public function createVoucherAddressQuery()
    {
        return new VoucherAddressQuery();
    }

    /**
     * @return VoucherBankData
     */
    public function createVoucherBankData()
    {
        return new VoucherBankData();
    }

    /**
     * @return VoucherBankDataQuery
     */
    public function createVoucherBankDataQuery()
    {
        return new VoucherBankDataQuery();
    }

    /**
     * @return VoucherTempMessages
     */
    public function createVoucherTempMessages()
    {
        return new VoucherTempMessages();
    }

    /**
     * @return VoucherTempMessagesQuery
     */
    public function createVoucherTempMessagesQuery()
    {
        return new VoucherTempMessagesQuery();
    }

    /**
     * @return ZipcodesTemp
     */
    public function createZipcodesTemp()
    {
        return new ZipcodesTemp();
    }

    /**
     * @return ZipcodesTempQuery
     */
    public function createZipcodesTempQuery()
    {
        return new ZipcodesTempQuery();
    }

    /**
     * @return JobChannel
     */
    public function createJobChannel()
    {
        return new JobChannel();
    }

    /**
     * @return JobChannelQuery
     */
    public function createJobChannelQuery()
    {
        return new JobChannelQuery();
    }

    /**
     * @return JobExternChannel
     */
    public function createJobExternChannel()
    {
        return new JobExternChannel();
    }

    /**
     * @return JobExternChannelQuery
     */
    public function createJobExternChannelQuery()
    {
        return new JobExternChannelQuery();
    }

    /**
     * @return CareerGoalChannel
     */
    public function createCareerGoalChannel()
    {
        return new CareerGoalChannel();
    }

    /**
     * @return CareerGoalChannelQuery
     */
    public function createCareerGoalChannelQuery()
    {
        return new CareerGoalChannelQuery();
    }

    /**
     * @return MappingFunctionChannel
     */
    public function createMappingFunctionChannel()
    {
        return new MappingFunctionChannel();
    }

    /**
     * @return MappingFunctionChannelQuery
     */
    public function createMappingFunctionChannelQuery()
    {
        return new MappingFunctionChannelQuery();
    }

    /**
     * @return SearchIndexQueue
     */
    public function createSearchIndexQueue()
    {
        return new SearchIndexQueue();
    }

    /**
     * @return SearchIndexQueueQuery
     */
    public function createSearchIndexQueueQuery()
    {
        return new SearchIndexQueueQuery();
    }

    /**
     * @return SearchIndexJob
     */
    public function createSearchIndexJob()
    {
        return new SearchIndexJob();
    }

    /**
     * @return SearchIndexJobQuery
     */
    public function createSearchIndexJobQuery()
    {
        return new SearchIndexJobQuery();
    }

    /**
     * @return PostSalesAddressEvent
     */
    public function createPostSalesAddressEvent()
    {
        return new PostSalesAddressEvent();
    }

    /**
     * @return PostSalesAddressEventQuery
     */
    public function createPostSalesAddressEventQuery()
    {
        return new PostSalesAddressEventQuery();
    }

    /**
     * @return UserSelfDeleteEvent
     */
    public function createUserSelfDeleteEvent()
    {
        return new UserSelfDeleteEvent();
    }

    /**
     * @return UserSelfDeleteEventQuery
     */
    public function createUserSelfDeleteEventQuery()
    {
        return new UserSelfDeleteEventQuery();
    }

    /**
     * @return SavedSearch
     */
    public function createSavedSearch()
    {
        return new SavedSearch();
    }

    /**
     * @return SavedSearchQuery
     */
    public function createSavedSearchQuery()
    {
        return new SavedSearchQuery();
    }

    /**
     * @return MappingLocationGeoId
     */
    public function createMappingLocationGeoId()
    {
        return new MappingLocationGeoId();
    }

    /**
     * @return MappingLocationGeoIdQuery
     */
    public function createMappingLocationGeoIdQuery()
    {
        return new MappingLocationGeoIdQuery();
    }

    /**
     * @return StatisticsSavedSearchSent
     */
    public function createStatisticsSavedSearchSent()
    {
        return new StatisticsSavedSearchSent();
    }

    /**
     * @return StatisticsSavedSearchSentQuery
     */
    public function createStatisticsSavedSearchSentQuery()
    {
        return new StatisticsSavedSearchSentQuery();
    }

    /**
     * @return ScheduledTask
     */
    public function createScheduledTask()
    {
        return new ScheduledTask();
    }

    /**
     * @return ScheduledTaskQuery
     */
    public function createScheduledTaskQuery()
    {
        return new ScheduledTaskQuery();
    }

    /**
     * @return ScheduledTaskParameter
     */
    public function createScheduledTaskParameter()
    {
        return new ScheduledTaskParameter();
    }

    /**
     * @return ScheduledTaskParameterQuery
     */
    public function createScheduledTaskParameterQuery()
    {
        return new ScheduledTaskParameterQuery();
    }

    /**
     * @return Event
     */
    public function createEvent()
    {
        return new Event();
    }

    /**
     * @return EventQuery
     */
    public function createEventQuery()
    {
        return new EventQuery();
    }

    /**
     * @return EventParameter
     */
    public function createEventParameter()
    {
        return new EventParameter();
    }

    /**
     * @return EventParameterQuery
     */
    public function createEventParameterQuery()
    {
        return new EventParameterQuery();
    }

    /**
     * @return JobLocation
     */
    public function createJobLocation()
    {
        return new JobLocation();
    }

    /**
     * @return JobLocationQuery
     */
    public function createJobLocationQuery()
    {
        return new JobLocationQuery();
    }

    /**
     * @return LocationCity
     */
    public function createLocationCity()
    {
        return new LocationCity();
    }

    /**
     * @return LocationCityQuery
     */
    public function createLocationCityQuery()
    {
        return new LocationCityQuery();
    }

    /**
     * @return LocationRegion
     */
    public function createLocationRegion()
    {
        return new LocationRegion();
    }

    /**
     * @return LocationRegionQuery
     */
    public function createLocationRegionQuery()
    {
        return new LocationRegionQuery();
    }

    /**
     * @return MappingIndustryCodeBranch
     */
    public function createMappingIndustryCodeBranch()
    {
        return new MappingIndustryCodeBranch();
    }

    /**
     * @return MappingIndustryCodeBranchQuery
     */
    public function createMappingIndustryCodeBranchQuery()
    {
        return new MappingIndustryCodeBranchQuery();
    }

    /**
     * @return MappingOperationAreasToChannels
     */
    public function createMappingOperationAreasToChannels()
    {
        return new MappingOperationAreasToChannels();
    }

    /**
     * @return MappingOperationAreasToChannelsQuery
     */
    public function createMappingOperationAreasToChannelsQuery()
    {
        return new MappingOperationAreasToChannelsQuery();
    }

    /**
     * @return MappingJobPositionToBenchmark
     */
    public function createMappingJobPositionToBenchmark()
    {
        return new MappingJobPositionToBenchmark();
    }

    /**
     * @return MappingJobPositionToBenchmarkQuery
     */
    public function createMappingJobPositionToBenchmarkQuery()
    {
        return new MappingJobPositionToBenchmarkQuery();
    }

    /**
     * @return JobExternHash
     */
    public function createJobExternHash()
    {
        return new JobExternHash();
    }

    /**
     * @return JobExternHashQuery
     */
    public function createJobExternHashQuery()
    {
        return new JobExternHashQuery();
    }

    /**
     * @return CompanyExtern
     */
    public function createCompanyExtern()
    {
        return new CompanyExtern();
    }

    /**
     * @return CompanyExternQuery
     */
    public function createCompanyExternQuery()
    {
        return new CompanyExternQuery();
    }

    /**
     * @return CompanyExternHash
     */
    public function createCompanyExternHash()
    {
        return new CompanyExternHash();
    }

    /**
     * @return CompanyExternHashQuery
     */
    public function createCompanyExternHashQuery()
    {
        return new CompanyExternHashQuery();
    }

    /**
     * @return CompanyExternBaseUrl
     */
    public function createCompanyExternBaseUrl()
    {
        return new CompanyExternBaseUrl();
    }

    /**
     * @return CompanyExternBaseUrlQuery
     */
    public function createCompanyExternBaseUrlQuery()
    {
        return new CompanyExternBaseUrlQuery();
    }

    /**
     * @return CompanyExternBaseUrlBlacklist
     */
    public function createCompanyExternBaseUrlBlacklist()
    {
        return new CompanyExternBaseUrlBlacklist();
    }

    /**
     * @return CompanyExternBaseUrlBlacklistQuery
     */
    public function createCompanyExternBaseUrlBlacklistQuery()
    {
        return new CompanyExternBaseUrlBlacklistQuery();
    }

    /**
     * @return CompanyExternDetails
     */
    public function createCompanyExternDetails()
    {
        return new CompanyExternDetails();
    }

    /**
     * @return CompanyExternDetailsQuery
     */
    public function createCompanyExternDetailsQuery()
    {
        return new CompanyExternDetailsQuery();
    }

    /**
     * @return ChannelToCompanyExtern
     */
    public function createChannelToCompanyExtern()
    {
        return new ChannelToCompanyExtern();
    }

    /**
     * @return ChannelToCompanyExternQuery
     */
    public function createChannelToCompanyExternQuery()
    {
        return new ChannelToCompanyExternQuery();
    }

    /**
     * @return StatisticsUnmatchedJobExternUrl
     */
    public function createStatisticsUnmatchedJobExternUrl()
    {
        return new StatisticsUnmatchedJobExternUrl();
    }

    /**
     * @return StatisticsUnmatchedJobExternUrlQuery
     */
    public function createStatisticsUnmatchedJobExternUrlQuery()
    {
        return new StatisticsUnmatchedJobExternUrlQuery();
    }

    /**
     * @return PlannedPregenerationQueue
     */
    public function createPlannedPregenerationQueue()
    {
        return new PlannedPregenerationQueue();
    }

    /**
     * @return PlannedPregenerationQueueQuery
     */
    public function createPlannedPregenerationQueueQuery()
    {
        return new PlannedPregenerationQueueQuery();
    }

    /**
     * @return PregeneratedJobChannelXml
     */
    public function createPregeneratedJobChannelXml()
    {
        return new PregeneratedJobChannelXml();
    }

    /**
     * @return PregeneratedJobChannelXmlQuery
     */
    public function createPregeneratedJobChannelXmlQuery()
    {
        return new PregeneratedJobChannelXmlQuery();
    }

    /**
     * @return PregeneratedJobLocationXml
     */
    public function createPregeneratedJobLocationXml()
    {
        return new PregeneratedJobLocationXml();
    }

    /**
     * @return PregeneratedJobLocationXmlQuery
     */
    public function createPregeneratedJobLocationXmlQuery()
    {
        return new PregeneratedJobLocationXmlQuery();
    }

    /**
     * @return PregeneratedJobExternChannelXml
     */
    public function createPregeneratedJobExternChannelXml()
    {
        return new PregeneratedJobExternChannelXml();
    }

    /**
     * @return PregeneratedJobExternChannelXmlQuery
     */
    public function createPregeneratedJobExternChannelXmlQuery()
    {
        return new PregeneratedJobExternChannelXmlQuery();
    }

    /**
     * @return PregeneratedJobExternLocationXml
     */
    public function createPregeneratedJobExternLocationXml()
    {
        return new PregeneratedJobExternLocationXml();
    }

    /**
     * @return PregeneratedJobExternLocationXmlQuery
     */
    public function createPregeneratedJobExternLocationXmlQuery()
    {
        return new PregeneratedJobExternLocationXmlQuery();
    }

    /**
     * @return PersistentValue
     */
    public function createPersistentValue()
    {
        return new PersistentValue();
    }

    /**
     * @return PersistentValueQuery
     */
    public function createPersistentValueQuery()
    {
        return new PersistentValueQuery();
    }

    /**
     * @return CareerLevel
     */
    public function createCareerLevel()
    {
        return new CareerLevel();
    }

    /**
     * @return CareerLevelQuery
     */
    public function createCareerLevelQuery()
    {
        return new CareerLevelQuery();
    }

    /**
     * @return CompetenceLevel
     */
    public function createCompetenceLevel()
    {
        return new CompetenceLevel();
    }

    /**
     * @return CompetenceLevelQuery
     */
    public function createCompetenceLevelQuery()
    {
        return new CompetenceLevelQuery();
    }

    /**
     * @return CompetenceExperience
     */
    public function createCompetenceExperience()
    {
        return new CompetenceExperience();
    }

    /**
     * @return CompetenceExperienceQuery
     */
    public function createCompetenceExperienceQuery()
    {
        return new CompetenceExperienceQuery();
    }

    /**
     * @return BatchjobProcessList
     */
    public function createBatchjobProcessList()
    {
        return new BatchjobProcessList();
    }

    /**
     * @return BatchjobProcessListQuery
     */
    public function createBatchjobProcessListQuery()
    {
        return new BatchjobProcessListQuery();
    }

    /**
     * @return BatchjobProcessHistory
     */
    public function createBatchjobProcessHistory()
    {
        return new BatchjobProcessHistory();
    }

    /**
     * @return BatchjobProcessHistoryQuery
     */
    public function createBatchjobProcessHistoryQuery()
    {
        return new BatchjobProcessHistoryQuery();
    }

    /**
     * @return JobExternVerificationActiveQueue
     */
    public function createJobExternVerificationActiveQueue()
    {
        return new JobExternVerificationActiveQueue();
    }

    /**
     * @return JobExternVerificationActiveQueueQuery
     */
    public function createJobExternVerificationActiveQueueQuery()
    {
        return new JobExternVerificationActiveQueueQuery();
    }

    /**
     * @return JobExternImportQueue
     */
    public function createJobExternImportQueue()
    {
        return new JobExternImportQueue();
    }

    /**
     * @return JobExternImportQueueQuery
     */
    public function createJobExternImportQueueQuery()
    {
        return new JobExternImportQueueQuery();
    }

    /**
     * @return UserCalculationProfileCompletenessQueue
     */
    public function createUserCalculationProfileCompletenessQueue()
    {
        return new UserCalculationProfileCompletenessQueue();
    }

    /**
     * @return UserCalculationProfileCompletenessQueueQuery
     */
    public function createUserCalculationProfileCompletenessQueueQuery()
    {
        return new UserCalculationProfileCompletenessQueueQuery();
    }

    /**
     * @return ExperianUserQueue
     */
    public function createExperianUserQueue()
    {
        return new ExperianUserQueue();
    }

    /**
     * @return ExperianUserQueueQuery
     */
    public function createExperianUserQueueQuery()
    {
        return new ExperianUserQueueQuery();
    }

    /**
     * @return ExperianTopJobQueue
     */
    public function createExperianTopJobQueue()
    {
        return new ExperianTopJobQueue();
    }

    /**
     * @return ExperianTopJobQueueQuery
     */
    public function createExperianTopJobQueueQuery()
    {
        return new ExperianTopJobQueueQuery();
    }

    /**
     * @return MigrationProfileCompletenessUpdateHistory
     */
    public function createMigrationProfileCompletenessUpdateHistory()
    {
        return new MigrationProfileCompletenessUpdateHistory();
    }

    /**
     * @return MigrationProfileCompletenessUpdateHistoryQuery
     */
    public function createMigrationProfileCompletenessUpdateHistoryQuery()
    {
        return new MigrationProfileCompletenessUpdateHistoryQuery();
    }

    /**
     * @return MigrationUserAddressLog
     */
    public function createMigrationUserAddressLog()
    {
        return new MigrationUserAddressLog();
    }

    /**
     * @return MigrationUserAddressLogQuery
     */
    public function createMigrationUserAddressLogQuery()
    {
        return new MigrationUserAddressLogQuery();
    }
}